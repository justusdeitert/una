#!/usr/bin/env bash
#
# Deploy to the production site on one.com shared hosting (no Docker there).
#
# Usage:
#   ./devops/scripts/onecom.sh deploy   # theme, WordPress core, plugins, config
#   ./devops/scripts/onecom.sh sync     # local DB + uploads (asks for confirmation)
#
# Settings (env vars, read from .env unless set in the shell):
#   ONECOM_SSH_HOST   SSH alias for the one.com account (default: onecom-una)
#   ONECOM_WP_PATH    WordPress folder on the server
#   ONECOM_DB_HOST    DB host for the mysql CLI tools (localhost does not work over SSH)
#   PRODUCTION_DOMAIN, STAGING_DOMAIN, LOCAL_DOMAIN, FULLPAGE_LICENSE_KEY
#
# WordPress lives in /wordpress on one.com and the webroot .htaccess rewrites
# everything into it, so siteurl ends in /wordpress and home is the bare domain.

set -euo pipefail

step() { printf '\n==> %s\n' "$*"; }
info() { printf '    %s\n' "$*"; }
fail() { printf 'error: %s\n' "$*" >&2; exit 1; }

repo_root=$(cd "$(dirname "${BASH_SOURCE[0]}")/../.." && pwd)
cd "$repo_root"

[ -f .env ] || fail ".env not found in $repo_root"

# A missing key yields an empty value instead of tripping set -e/pipefail
read_env() {
    { grep -E "^$1=" .env || true; } | head -n1 | cut -d= -f2- | sed -E 's/^"(.*)"$/\1/; s/^'\''(.*)'\''$/\1/'
}

SSH_HOST="${ONECOM_SSH_HOST:-$(read_env ONECOM_SSH_HOST)}"
SSH_HOST="${SSH_HOST:-onecom-una}"
WP_PATH="${ONECOM_WP_PATH:-$(read_env ONECOM_WP_PATH)}"
WP_PATH="${WP_PATH:-/customers/d/9/0/cirrnozto/webroots/www/wordpress}"
DB_HOST="${ONECOM_DB_HOST:-$(read_env ONECOM_DB_HOST)}"
DB_HOST="${DB_HOST:-mysql.cirrnozto.service.one}"

DOMAIN=$(read_env PRODUCTION_DOMAIN)
STAGING_DOMAIN=$(read_env STAGING_DOMAIN)
[ -n "$DOMAIN" ] || fail "PRODUCTION_DOMAIN must be set in .env"

THEME_SLUG=una-moehrke-theme
remote() { ssh "$SSH_HOST" "cd $WP_PATH && $1"; }
remote_wp() { remote "wp $1"; }

deploy() {
    step "Building theme assets"
    docker compose exec node yarn build

    step "Uploading theme to $SSH_HOST:$WP_PATH/wp-content/themes/$THEME_SLUG/"
    # Apache on one.com needs world-readable files, whatever the local modes are
    rsync -az --delete --stats --human-readable \
        --chmod=D755,F644 \
        --exclude='.DS_Store' \
        --exclude='node_modules/' \
        --exclude='stats.html' \
        --exclude='.php-cs-fixer.cache' \
        ./theme/ "$SSH_HOST:$WP_PATH/wp-content/themes/$THEME_SLUG/"

    wp_version=$(sed -nE 's/^ENV WORDPRESS_VERSION=([0-9.]+).*/\1/p' devops/Dockerfile)
    [ -n "$wp_version" ] || fail "WORDPRESS_VERSION not found in devops/Dockerfile"
    step "Updating WordPress core to $wp_version"
    remote_wp "core update --version=$wp_version"
    remote_wp "core update-db"

    step "Installing plugins from devops/plugins.txt"
    # SCF and ACF Pro cannot be active at the same time
    if grep -q '^secure-custom-fields:' devops/plugins.txt; then
        remote_wp "plugin deactivate advanced-custom-fields-pro" || true
    fi
    wanted=()
    # Read the list on fd 3: ssh inside the loop would consume stdin
    while IFS=: read -r slug version flag <&3; do
        [ -n "$slug" ] && [ "${slug:0:1}" != "#" ] || continue
        wanted+=("$slug")
        args="--version=$version --force"
        [ "$flag" = "activate" ] && args="$args --activate"
        remote_wp "plugin install $slug $args" < /dev/null
    done 3< devops/plugins.txt

    step "Deactivating plugins not in devops/plugins.txt"
    for slug in $(remote_wp "plugin list --status=active --field=name"); do
        [[ " ${wanted[*]} " == *" $slug "* ]] || remote_wp "plugin deactivate $slug"
    done

    step "Setting wp-config constants"
    remote_wp "config set WP_ENVIRONMENT_TYPE production --type=constant --quiet"
    license=$(read_env FULLPAGE_LICENSE_KEY)
    if [ -n "$license" ]; then
        remote_wp "config set FULLPAGE_LICENSE_KEY '$license' --type=constant --quiet"
        info "FULLPAGE_LICENSE_KEY set"
    else
        info "FULLPAGE_LICENSE_KEY empty in .env, skipped"
    fi

    remote_wp "cache flush" || true
    remote "rm -rf wp-content/cache/cache-enabler"

    step "Done. Theme, core and plugins deployed to $DOMAIN."
}

sync() {
    local dump="db/db-export.sql"
    [ -d ./uploads ] || fail "uploads/ directory not found at $repo_root/uploads"

    cat <<WARN

!!! WARNING: about to overwrite PRODUCTION (https://$DOMAIN) on one.com !!!

  - Remote DB tables will be dropped and replaced with your local DB.
  - Remote uploads will be merged with ./uploads (no deletion of remote-only files).
  - A backup of the remote DB will be written to ~/backups on $SSH_HOST first.

To proceed, type the production domain exactly:
  expected: $DOMAIN

WARN
    printf '> '
    read -r confirm
    [ "$confirm" = "$DOMAIN" ] || fail "confirmation mismatch, aborting"

    step "Exporting local DB with production domain replacement"
    docker compose exec -e TARGET=production php /devops/scripts/db-export.sh
    [ -f "$dump" ] || fail "expected $dump after export"

    backup="~/backups/db-$(date +%Y%m%d-%H%M%S).sql"
    step "Backing up remote DB to $SSH_HOST:$backup"
    ssh "$SSH_HOST" "mkdir -p ~/backups"
    remote_wp "db export $backup --host=$DB_HOST"

    step "Replacing remote DB with $dump"
    # wp db import/reset/clean call the mysql client with DB_HOST=localhost,
    # which has no socket over SSH. Use mysql directly with the right host.
    # The dump has DROP TABLE IF EXISTS for every table.
    remote "MYSQL_PWD=\"\$(wp config get DB_PASSWORD)\" mysql --default-character-set=utf8mb4 -h $DB_HOST -u \"\$(wp config get DB_USER)\" \"\$(wp config get DB_NAME)\"" < "$dump"

    step "Pointing the remote DB at https://$DOMAIN"
    if [ -n "$STAGING_DOMAIN" ]; then
        remote_wp "search-replace '//$STAGING_DOMAIN' '//$DOMAIN' --all-tables --skip-columns=guid --report-changed-only"
    fi
    remote_wp "search-replace 'http://$DOMAIN' 'https://$DOMAIN' --all-tables --skip-columns=guid --report-changed-only"
    remote_wp "option update home 'https://$DOMAIN'"
    remote_wp "option update siteurl 'https://$DOMAIN/wordpress'"

    step "Rsyncing local uploads/ to $SSH_HOST:$WP_PATH/wp-content/uploads/"
    rsync -az --stats --human-readable \
        --chmod=D755,F644 \
        --exclude='cache/' \
        ./uploads/ "$SSH_HOST:$WP_PATH/wp-content/uploads/"

    remote_wp "cache flush" || true
    remote "rm -rf wp-content/cache/cache-enabler"

    step "Done. Local DB and uploads synced to $DOMAIN."
}

case "${1:-}" in
    deploy) deploy ;;
    sync) sync ;;
    *) fail "usage: $0 deploy|sync" ;;
esac
