FROM php:8.2-cli

WORKDIR /app

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip

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

# Clear cache (important: do this after assets install)
RUN APP_ENV=prod php bin/console cache:clear --no-debug --no-warmup
RUN APP_ENV=prod php bin/console cache:warmup

EXPOSE 8000

CMD ["symfony", "server:start", "--port=8000", "--no-tls"]
