FROM php:8.2-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    curl \
    libpq-dev \
    libmcrypt-dev \
    git \
    unzip \
    sqlite3 \
    && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_mysql pdo_sqlite

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /app

# Copy composer files first
COPY composer.json composer.lock ./

# Install PHP dependencies
RUN composer install --no-interaction --no-dev --optimize-autoloader

# Copy entire project
COPY . .

# Create cache directory
RUN mkdir -p bootstrap/cache storage/logs && chmod -R 775 bootstrap/cache storage logs

# Generate app key
RUN php artisan key:generate --force || true

# Expose port
EXPOSE 8000

# Run artisan serve
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
