#!/bin/bash

# Wait for the database to be ready
/usr/local/bin/wait-for-it.sh db:3306 --timeout=30 --strict -- echo "Database is up"

# Install WordPress
if [ ! -f wp-config.php ]; then
    echo "wp core download"
    wp core download --version=6.1.1 --allow-root
    echo "wp config create"
    wp config create --dbname=$WORDPRESS_DB_NAME --dbuser=$WORDPRESS_DB_USER --dbhost=$WORDPRESS_DB_HOST --dbpass=$WORDPRESS_DB_PASSWORD --allow-root
    echo "wp core install"
    wp core install --url="http://localhost" --title="Wordpress" --admin_user=$WORDPRESS_ADMIN_USER --admin_password=$WORDPRESS_ADMIN_PASSWORD --admin_email=$WORDPRESS_ADMIN_EMAIL --allow-root
fi

# Uncomment the following lines to install plugins
# Define an array of plugin slugs
plugins=(
    wordpress-seo
    contact-form-7
    w3-total-cache
    jetpack
    akismet
    clean-image-filenames
    disable-blog
    enable-media-replace
    google-sitemap-generator
    imsanity
    disable-comments
    phoenix-media-rename
    svg-support
    user-switching
    pc-robotstxt
    classic-editor
)

# Install plugins
# for plugin in "${plugins[@]}"; do
#     wp plugin install $plugin --activate --allow-root
# done

# ACF Pro
# wp plugin install 'http://connect.advancedcustomfields.com/index.php?p=pro&a=download&k=b3JkZXJfaWQ9MTgzNTYwfHR5cGU9cGVyc29uYWx8ZGF0ZT0yMDIwLTAxLTE4IDE0OjE3OjAw' --activate --allow-root