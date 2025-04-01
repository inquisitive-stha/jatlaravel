#!/bin/bash
set -e

## Function to fix permissions
#fix_permissions() {
#  chown -R laravel:laravel /var/www/jatlaravel/storage
#  chmod -R 775 /var/www/jatlaravel/storage
#  chown -R laravel:laravel /var/www/jatlaravel/bootstrap/cache
#  chmod -R 775 /var/www/jatlaravel/bootstrap/cache
#}
#
## Fix permissions first
#fix_permissions

# Fix storage permissions
chown -R laravel:laravel /var/www/jatlaravel/storage
chmod -R 775 /var/www/jatlaravel/storage
chown -R laravel:laravel /var/www/jatlaravel/bootstrap/cache
chmod -R 775 /var/www/jatlaravel/bootstrap/cache

# Create required directories if they don't exist
mkdir -p /var/www/jatlaravel/storage/framework/{sessions,views,cache}
chmod -R 775 /var/www/jatlaravel/storage/framework

# Handle php-fpm separately (needs root for binding to ports)
if [ "$1" = "php-fpm" ]; then
    exec "$@"
else
    # All other commands run as laravel user
    exec gosu laravel "$@"
fi