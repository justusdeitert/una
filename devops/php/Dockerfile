FROM php:8.4-fpm

# Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y --no-install-recommends \
    curl \
    less \
    mariadb-client \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libwebp-dev \
    libzip-dev \
    libicu-dev \
    zip \
    unzip \
    tree \
    git \
    && docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp \
    && docker-php-ext-install -j$(nproc) mysqli gd zip intl opcache \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Wrap mariadb client to add --skip-ssl (WP-CLI uses --no-defaults which ignores config files)
RUN mv /usr/bin/mariadb /usr/bin/mariadb-real
COPY --chmod=755 devops/php/mariadb-wrapper.sh /usr/bin/mariadb

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install PHP-CS-Fixer
RUN composer global require friendsofphp/php-cs-fixer --no-interaction \
    && ln -s /root/.composer/vendor/bin/php-cs-fixer /usr/local/bin/php-cs-fixer

# Install WP-CLI
RUN curl -O https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar \
    && chmod +x wp-cli.phar \
    && mv wp-cli.phar /usr/local/bin/wp

WORKDIR /var/www/html

# Scripts are bind-mounted from ./devops (see docker-compose.yml)
ENTRYPOINT ["/devops/php/entrypoint.sh"]