FROM php:8.2-fpm

WORKDIR /var/www/jatlaravel

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
    curl \
    gosu

RUN apt-get clean && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install pdo pdo_mysql pdo_sqlite mbstring exif pcntl bcmath gd

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Create a non-root user that matches the host user ID
ARG USER_ID=1000
ARG GROUP_ID=1000

RUN if getent group ${GROUP_ID}; then \
        groupdel $(getent group ${GROUP_ID} | cut -d: -f1); \
    fi && \
    if getent passwd ${USER_ID}; then \
        userdel $(getent passwd ${USER_ID} | cut -d: -f1); \
    fi && \
    groupadd -g ${GROUP_ID} laravel && \
    useradd -u ${USER_ID} -g laravel -m -s /bin/bash laravel

RUN mkdir -p /var/www/jatlaravel && \
    chown -R laravel:laravel /var/www/jatlaravel

COPY docker/php/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
CMD ["php-fpm"]