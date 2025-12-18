FROM php:8.2-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    curl \
    libpq-dev \
    libmcrypt-dev \
    git \
    unzip \
    sqlite3 \
    libsqlite3-dev \
    && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_mysql pdo_sqlite

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /app

# Copy composer files first
COPY composer.json composer.lock ./

# Install PHP dependencies (without dev)
RUN composer install --no-interaction --no-dev --optimize-autoloader

# Copy entire project
COPY . .

# Fix permissions
RUN chown -R www-data:www-data /app

# Create necessary directories with proper permissions
RUN mkdir -p \
    bootstrap/cache \
    storage/logs \
    storage/framework \
    storage/framework/cache \
    storage/framework/sessions \
    storage/framework/views \
    database && \
    chmod -R 775 bootstrap/cache storage database && \
    chmod -R 775 storage/logs

# Create database file if it doesn't exist
RUN touch database/database.sqlite

# Generate app key
RUN php artisan key:generate --force 2>/dev/null || true

# Run migrations (optional but recommended)
RUN php artisan migrate --force 2>/dev/null || true

# Expose port
EXPOSE 8000

# Health check
HEALTHCHECK --interval=30s --timeout=10s --start-period=5s --retries=3 \
    CMD curl -f http://localhost:8000/up || exit 1

# Run artisan serve
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
