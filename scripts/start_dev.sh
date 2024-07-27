#!/bin/sh

# Create log directory for supervisor and set permissions
mkdir -p /app/storage/logs/supervisor
chmod -R 777 /app/storage/logs/supervisor

# Wait for Redis to be ready
# /usr/local/bin/wait-for-it.sh db:3306

# Run Laravel artisan commands
if [ ! -L /app/public/storage ]; then
    php artisan storage:link
fi

php artisan key:generate --force 
php artisan config:clear
php artisan config:cache
php artisan route:clear
php artisan route:cache


# Start supervisord to manage queue worker and Laravel server
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
