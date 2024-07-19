#!/bin/sh

# Wait for Redis to be ready
/usr/local/bin/wait-for-it.sh db:3306

# Run Laravel artisan commands
if [ ! -L /var/www/app/public/storage ]; then
    php artisan storage:link
fi

php artisan key:generate --force 
php artisan config:clear
php artisan config:cache
php artisan route:clear
php artisan route:cache


# Start php-artisan
php artisan schedule:work &
php artisan queue:work --tries=3 &
php artisan serve --host=0.0.0.0 --port=8000 
