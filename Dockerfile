FROM php:8.2-cli

WORKDIR /app

# Install system dependencies (sans wget)
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip
    # Supprimez wget

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy application
COPY . .

# Install dependencies (PRODUCTION)
RUN composer install --no-dev --optimize-autoloader --no-scripts

# Install assets
RUN php bin/console assets:install public --env=prod --no-debug

# Clear cache
RUN APP_ENV=prod php bin/console cache:clear --no-debug --no-warmup
RUN APP_ENV=prod php bin/console cache:warmup

EXPOSE 8000

CMD ["php", "-S", "0.0.0.0:8000", "public/index.php"]
