#!/bin/sh

# Create log directory for supervisor and set permissions
mkdir -p /var/www/html/storage/logs/supervisor
chmod -R 777 /var/www/html/storage/logs/supervisor
chmod -R 777 /var/www/html/storage/framework

# Run Laravel artisan commands
if [ ! -L /var/www/html/public/storage ]; then
    php artisan storage:link
fi

php artisan key:generate --force 
php artisan cache:clear
php artisan config:clear
php artisan config:cache
php artisan route:clear
php artisan route:cache
composer dump-autoload --optimize

# Start supervisord to manage queue worker and Laravel server
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
