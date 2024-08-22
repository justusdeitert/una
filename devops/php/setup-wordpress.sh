#!/bin/bash

# wp search-replace 'una-moehrke.de' 'localhost:8080' --allow-root

# Wait for the database to be ready
/usr/local/bin/wait-for-it.sh mysql:3306 --timeout=30 --strict -- echo "Database is up"

# Install WordPress
if [ ! -f wp-config.php ]; then
    echo "wp core download"
    wp core download --version=6.6.1 --allow-root
    echo "wp config create"
    wp config create --dbname="$MYSQL_DATABASE" --dbuser="$MYSQL_USER" --dbhost="$MYSQL_HOST" --dbpass="$MYSQL_PASSWORD" --allow-root
    echo "wp core install"
    wp core install --url="$WORDPRESS_URL" --title="$WORDPRESS_TITLE" --admin_user="$WORDPRESS_ADMIN_USER" --admin_password="$WORDPRESS_ADMIN_PASSWORD" --admin_email="$WORDPRESS_ADMIN_EMAIL" --allow-root
fi

# Define an array of plugin slugs with versions
plugins=(
    "wordpress-seo:19.5"
    "jetpack:13.7"
    "clean-image-filenames:1.5"
    "disable-blog:0.5.4"
    "enable-media-replace:4.1.5"
    "imsanity:2.8.2"
    "disable-comments:2.4.6"
    "phoenix-media-rename:3.11.8"
    "svg-support:2.5.8"
    "user-switching:1.8.0"
    "pc-robotstxt:1.10"
    "converter-for-media:5.13.1"
    "cache-enabler:1.8.15"
)

# Install plugins
for plugin in "${plugins[@]}"; do
    IFS=":" read -r plugin_slug plugin_version <<< "$plugin"
    wp plugin install "$plugin_slug" --version="$plugin_version" --activate --allow-root
done

# Start PHP-FPM to keep the container running
php-fpm