#!/bin/bash

# Exit on error
set -e

echo "Starting Laravel application..."

# Run Laravel setup commands
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Run migrations if needed (optional - uncomment if you want auto-migration)
# php artisan migrate --force

# Start supervisord to manage nginx and php-fpm
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
