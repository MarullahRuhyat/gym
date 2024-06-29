# Stage 1: Build stage
FROM composer:2.7.1 as composer

WORKDIR /app

# Copy composer files
COPY composer.json composer.json
COPY composer.lock composer.lock

# Install dependencies
RUN composer install --ignore-platform-reqs --no-scripts --no-autoloader

# Copy the rest of the application
COPY . .

# Generate autoload files
RUN composer dump-autoload --no-scripts --no-dev --optimize

# Build assets (if needed)
# RUN npm install && npm run production

# Stage 2: Production stage
FROM nginx:latest

# Copy Laravel configuration for Nginx
COPY docker/nginx/default.conf /etc/nginx/conf.d/default.conf

# Copy built assets from previous stage
COPY --from=composer /app /app
# Expose port 80 (default for HTTP)
EXPOSE 80

# Command to run Nginx in foreground
CMD ["nginx", "-g", "daemon off;"]
