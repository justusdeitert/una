#!/bin/bash

# Run the WordPress setup script
/devops/php/setup-wordpress.sh

# Start PHP-FPM
exec php-fpm