#!/bin/bash
set -e

export WP_CLI_PHP_ARGS="-d memory_limit=512M"

/usr/local/bin/wait-for-it.sh mysql:3306 --timeout=30 --strict -- echo "Database is up"

if ! command -v wp &> /dev/null; then
    echo "wp-cli could not be found."
    exit 1
fi

if [ ! -f wp-config.php ]; then
    echo "wp core download"
    wp core download --version="$WORDPRESS_VERSION" --allow-root

    echo "wp config create"
    wp config create --dbname="$MYSQL_DATABASE" --dbuser="$MYSQL_USER" --dbhost="$MYSQL_HOST" --dbpass="$MYSQL_PASSWORD" --allow-root

    echo "wp core install"
    wp core install --url="$WORDPRESS_URL" --title="$WORDPRESS_TITLE" --admin_user="$WORDPRESS_ADMIN_USER" --admin_password="$WORDPRESS_ADMIN_PASSWORD" --admin_email="$WORDPRESS_ADMIN_EMAIL" --allow-root

    plugins=(
        "autodescription:5.1.4:activate"
        "cache-enabler:1.8.16"
        "clean-image-filenames:1.5:activate"
        "disable-blog:0.5.5:activate"
        "disable-comments:2.7.0:activate"
        "enable-media-replace:4.1.8:activate"
        "imsanity:2.9.0:activate"
        "jetpack:15.7"
        "phoenix-media-rename:3.13.1:activate"
        "svg-support:2.5.14:activate"
        "user-switching:1.11.2:activate"
        "webp-converter-for-media:6.5.5:activate"
    )

    for plugin in "${plugins[@]}"; do
        IFS=":" read -r plugin_slug plugin_version plugin_action <<< "$plugin"

        if [ "$plugin_action" == "activate" ]; then
            wp plugin install "$plugin_slug" --version="$plugin_version" --activate --allow-root
        else
            wp plugin install "$plugin_slug" --version="$plugin_version" --allow-root
        fi
    done

    echo "Activating theme $WORDPRESS_THEME"
    wp theme activate "$WORDPRESS_THEME" --allow-root
fi