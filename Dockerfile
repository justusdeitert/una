FROM wordpress:latest

# Install WP-CLI
RUN curl -O https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar \
    && chmod +x wp-cli.phar \
    && mv wp-cli.phar /usr/local/bin/wp

# Install wait-for-it script
ADD https://raw.githubusercontent.com/vishnubob/wait-for-it/master/wait-for-it.sh /usr/local/bin/wait-for-it.sh
RUN chmod +x /usr/local/bin/wait-for-it.sh

# Copy the setup script into the container
COPY setup-wordpress.sh /usr/local/bin/setup-wordpress.sh

# Make the script executable
RUN chmod +x /usr/local/bin/setup-wordpress.sh

# Set the entrypoint to the setup script
ENTRYPOINT ["/usr/local/bin/setup-wordpress.sh"]