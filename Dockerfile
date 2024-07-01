# Gunakan image PHP yang sesuai
FROM php:8.2-cli

# Install dependencies yang diperlukan
RUN apt-get update \
    && apt-get install -y \
        git \
        unzip \
        libzip-dev \
    && docker-php-ext-install zip pdo_mysql
    # jika butuh redis
    # && pecl install redis \
    # && docker-php-ext-enable redis

# cd direktory project
WORKDIR /app

# Copy only necessary files for Composer dependencies
COPY composer.json composer.lock ./

# Install dependencies menggunakan Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && composer install --ignore-platform-reqs --no-scripts --no-autoloader

# Copy the rest of the application
COPY . .

# Generate autoload files untuk efisiensi
RUN composer dump-autoload --optimize

# Expose the port Laravel is running on
EXPOSE 8000

# Command to run the application
# CMD ["php", "artisan", "php artisan serve --host=0.0.0.0 --port=8000"]
