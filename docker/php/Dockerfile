FROM php:8.2-fpm

# Set working directory
WORKDIR /var/www/jatlaravel

# Install dependencies including sqlite3
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libsqlite3-dev \
    sqlite3 \
    zip \
    unzip \
    git \
    curl

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_mysql pdo_sqlite mbstring exif pcntl bcmath gd

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install Laravel Installer
#RUN composer global require laravel/installer

# Add composer vendor bin to PATH
#ENV PATH="$PATH:/root/.composer/vendor/bin"

# Install Laravel 12 project with Laravel Installer
# We'll run this as part of the entrypoint script instead of here

# Copy entrypoint script
#COPY docker/php/entrypoint.sh /usr/local/bin/entrypoint.sh
#RUN chmod +x /usr/local/bin/entrypoint.sh

# Set the entrypoint
#ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]

# Start php-fpm
CMD ["php-fpm"]