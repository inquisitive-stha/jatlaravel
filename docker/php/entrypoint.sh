#!/bin/bash
set -e

# Function to fix permissions appropriately
fix_permissions() {
    # Create directories if they don't exist
    mkdir -p /var/www/jatlaravel/storage/logs
    mkdir -p /var/www/jatlaravel/storage/framework/cache
    mkdir -p /var/www/jatlaravel/storage/framework/sessions
    mkdir -p /var/www/jatlaravel/storage/framework/views
    mkdir -p /var/www/jatlaravel/bootstrap/cache

    # Fix permissions
    find /var/www/jatlaravel/storage -type d -exec chmod 775 {} \;
    find /var/www/jatlaravel/storage -type f -exec chmod 664 {} \;
    chmod -R 775 /var/www/jatlaravel/bootstrap/cache

    # Set ownership
    chown -R laravel:laravel /var/www/jatlaravel
}

# Create Laravel project if needed
if [ ! -f "/var/www/jatlaravel/artisan" ]; then
    gosu laravel composer create-project laravel/laravel . --prefer-dist
    fix_permissions
fi

# Always fix permissions for critical directories
fix_permissions

# Special case for php-fpm which needs to be run as root initially
if [ "$1" = "php-fpm" ]; then
    # This allows PHP-FPM to bind to privileged ports and write to stdout/stderr
    exec "$@"
else
    # Run other commands as laravel user
    exec gosu laravel "$@"
fi