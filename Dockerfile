# Stage 1: Install dependencies using Composer 2.7.1
FROM composer:2.7.1 as composer

WORKDIR /app

# Copy only necessary files for Composer dependencies
COPY composer.json composer.lock ./

# Install all dependencies, including require-dev
RUN composer install --ignore-platform-reqs --no-scripts --no-autoloader

# Copy the rest of the application
COPY . .

# Generate optimized autoload files
RUN composer dump-autoload --optimize

# Stage 2: Build the application
FROM php:8.3-cli

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql

WORKDIR /app

# Copy only necessary files from the composer stage
COPY --from=composer /app /app

# Expose the port Laravel is running on
EXPOSE 8000

# Command to run the application
# CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
