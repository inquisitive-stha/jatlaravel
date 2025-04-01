#!/bin/bash
set -e

# Function to fix permissions
fix_permissions() {
    mkdir -p /var/www/jatlaravel/storage/logs
    mkdir -p /var/www/jatlaravel/storage/framework/{cache,sessions,views}
    mkdir -p /var/www/jatlaravel/bootstrap/cache
    mkdir -p /var/www/jatlaravel/config

    chown -R laravel:laravel /var/www/jatlaravel
    chmod -R 775 /var/www/jatlaravel/storage /var/www/jatlaravel/bootstrap/cache
}

# Fix permissions first
fix_permissions

# Handle php-fpm separately (needs root for binding to ports)
if [ "$1" = "php-fpm" ]; then
    exec "$@"
else
    # All other commands run as laravel user
    exec gosu laravel "$@"
fi