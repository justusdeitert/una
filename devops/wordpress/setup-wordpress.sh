#!/bin/bash

# Wait for the database to be ready
/usr/local/bin/wait-for-it.sh mysql:3306 --timeout=30 --strict -- echo "Database is up"

# Install WordPress
if [ ! -f wp-config.php ]; then
    echo "wp core download"
    wp core download --version=6.1.1 --allow-root
    echo "wp config create"
    wp config create --dbname="$WORDPRESS_DB_NAME" --dbuser="$WORDPRESS_DB_USER" --dbhost="$WORDPRESS_DB_HOST" --dbpass="$WORDPRESS_DB_PASSWORD" --allow-root
    echo "wp core install"
    wp core install --url="$WORDPRESS_URL" --title="$WORDPRESS_TITLE" --admin_user="$WORDPRESS_ADMIN_USER" --admin_password="$WORDPRESS_ADMIN_PASSWORD" --admin_email="$WORDPRESS_ADMIN_EMAIL" --allow-root
fi

# Define an array of plugin slugs with versions
plugins=(
    "wordpress-seo:19.5"
    "contact-form-7:5.6.1"
    "w3-total-cache:2.2.4"
    "jetpack:11.1"
    "akismet:4.2.2"
    "clean-image-filenames:1.3"
    "disable-blog:0.5.1"
    "enable-media-replace:4.0.1"
    "google-sitemap-generator:4.1.7"
    "imsanity:2.8.2"
    "disable-comments:2.4.2"
    "phoenix-media-rename:3.8.8"
    "svg-support:2.5.5"
    "user-switching:1.7.0"
    "pc-robotstxt:1.10"
)

# Install plugins
for plugin in "${plugins[@]}"; do
    IFS=":" read -r plugin_slug plugin_version <<< "$plugin"
    wp plugin install "$plugin_slug" --version="$plugin_version" --activate --allow-root
done