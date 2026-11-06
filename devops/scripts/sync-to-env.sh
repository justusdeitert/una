#!/usr/bin/env bash
#
# Sync the local development environment (DB + uploads) to a remote
# WordPress deployment running on Coolify (staging only, production runs
# on one.com, see onecom.sh).
#
# Usage:
#   TARGET=staging    ./devops/scripts/sync-to-env.sh
#
# Required env vars (read from .env unless overridden in the shell):
#   LOCAL_DOMAIN
#   STAGING_DOMAIN, PRODUCTION_DOMAIN
#   STAGING_SSH_HOST (default: hetzner)
#
# Steps:
#   1. Export the local DB through wp-cli with LOCAL_DOMAIN -> ENV_DOMAIN
#      search-replace (handled by db-export.sh in the php container).
#   2. Reset the remote DB and stream the dump into `wp db import`.
#   3. Swap any remaining OTHER_DOMAIN URLs and force https for ENV_DOMAIN.
#   4. Rsync ./uploads into the remote uploads volume (with --delete).
#
# Safety:
#   - the remote deployment is resolved from the Coolify compose project
#     whose nginx serves ENV_DOMAIN (other sites share the server).

set -euo pipefail

TARGET="${TARGET:-}"
ENV_NAME="$TARGET"
# shellcheck source=sync-common.sh
. "$(dirname "$0")/sync-common.sh"

RSYNC_DELETE="--delete"

DUMP_FILE="db/db-export.sql"

[ -d "./uploads" ] || fail "uploads/ directory not found at $repo_root/uploads"

resolve_deployment

# --- 1. Export local DB ----------------------------------------------------
step "Exporting local DB with $TARGET domain replacement ($LOCAL_DOMAIN -> $ENV_DOMAIN)"
docker compose exec -e TARGET="$TARGET" php /devops/scripts/db-export.sh
[ -f "$DUMP_FILE" ] || fail "expected $DUMP_FILE after export"

# --- 2. Import ------------------------------------------------------------
step "Replacing remote DB with $DUMP_FILE"
remote_wp "db reset --yes"
remote_wp "db import -" < "$DUMP_FILE"

# --- 3. Point the remote DB at ENV_DOMAIN -------------------------------
step "Replacing $OTHER_DOMAIN with $ENV_DOMAIN and forcing https"
remote_wp "search-replace '//$OTHER_DOMAIN' '//$ENV_DOMAIN' --all-tables --skip-columns=guid --report-changed-only"
remote_wp "search-replace 'http://$ENV_DOMAIN' 'https://$ENV_DOMAIN' --all-tables --skip-columns=guid --report-changed-only"
remote_wp "cache flush" || true

# --- 4. Sync uploads ------------------------------------------------------
step "Rsyncing local uploads/ to $SSH_HOST:$UPLOADS_PATH/"
# shellcheck disable=SC2086
rsync -az $RSYNC_DELETE --stats --human-readable \
  --exclude='cache/' \
  ./uploads/ "$SSH_HOST:$UPLOADS_PATH/"

# rsync keeps the local uid, which www-data cannot write to
ssh "$SSH_HOST" "docker exec $PHP_CONTAINER chown -R www-data:www-data wp-content/uploads"

step "Done. Local DB and uploads synced to $TARGET ($ENV_DOMAIN)."
