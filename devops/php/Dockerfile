FROM php:8.2-fpm

# Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y --no-install-recommends \
    curl \
    less \
    vim \
    mariadb-client \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    libicu-dev \
    zip \
    unzip \
    tree \
    zsh \
    git \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) mysqli gd zip intl opcache \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Wrap mariadb client to add --skip-ssl (WP-CLI uses --no-defaults which ignores config files)
RUN mv /usr/bin/mariadb /usr/bin/mariadb-real \
    && printf '#!/bin/sh\nif [ "$1" = "--no-defaults" ]; then\n  shift\n  exec /usr/bin/mariadb-real --no-defaults --skip-ssl "$@"\nelse\n  exec /usr/bin/mariadb-real --skip-ssl "$@"\nfi\n' > /usr/bin/mariadb \
    && chmod +x /usr/bin/mariadb

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install WP-CLI
RUN curl -O https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar \
    && chmod +x wp-cli.phar \
    && mv wp-cli.phar /usr/local/bin/wp

# Install wait-for-it script
ADD --chmod=755 https://raw.githubusercontent.com/vishnubob/wait-for-it/master/wait-for-it.sh /usr/local/bin/wait-for-it.sh

# Install Oh My Zsh
RUN sh -c "$(curl -fsSL https://raw.githubusercontent.com/ohmyzsh/ohmyzsh/master/tools/install.sh)" "" --unattended \
    && chsh -s $(which zsh)

# Copy scripts
COPY --chmod=755 devops/php/entrypoint.sh /usr/local/bin/entrypoint.sh
COPY --chmod=755 devops/php/setup-wordpress.sh /usr/local/bin/setup-wordpress.sh
COPY --chmod=755 devops/php/search-replace-export-db.sh /usr/local/bin/search-replace-export-db.sh
COPY --chmod=755 devops/php/search-replace-import-db.sh /usr/local/bin/search-replace-import-db.sh

# Set the working directory
WORKDIR /var/www/html

# Set the entrypoint to the setup script
ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]