#!/bin/bash

# Check if the Laravel project already exists
if [ ! -f "/var/www/jatlaravel/artisan" ]; then
    echo "Creating new Laravel 12 project..."
    cd /tmp
    laravel new jatlaravel --github --jet --teams
    # Move all Laravel project files to the working directory
    shopt -s dotglob
    mv /tmp/jatlaravel/* /var/www/jatlaravel/
    cd /var/www/jatlaravel

    # Update .env file with MySQL connection settings
    sed -i 's/DB_HOST=127.0.0.1/DB_HOST=jatlaravel_db/g' .env
    sed -i 's/DB_DATABASE=laravel/DB_DATABASE=jatlaravel_db/g' .env
    sed -i 's/DB_USERNAME=root/DB_USERNAME=db_user/g' .env
    sed -i 's/DB_PASSWORD=/DB_PASSWORD=db_password/g' .env

    # Set directory permissions
    chown -R www-data:www-data /var/www/jatlaravel/storage
    chmod -R 775 /var/www/jatlaravel/storage /var/www/jatlaravel/bootstrap/cache

    echo "Laravel 12 project created successfully!"
else
    echo "Laravel project already exists."
fi

# Execute the main container command
exec "$@"