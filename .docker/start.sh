#!/bin/bash

# Exit on error
set -e

echo "Starting Laravel application..."

# Verify Vite manifest exists
if [ ! -f "public/build/.vite/manifest.json" ]; then
    echo "ERROR: Vite manifest not found at public/build/.vite/manifest.json"
    echo "Listing public/build contents:"
    ls -la public/build/ || echo "public/build directory does not exist"
    echo "Listing public/build/.vite contents:"
    ls -la public/build/.vite/ || echo "public/build/.vite directory does not exist"
    exit 1
fi

echo "Vite manifest found successfully"

# Run Laravel setup commands
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Run migrations if needed (optional - uncomment if you want auto-migration)
# php artisan migrate --force

# Start supervisord to manage nginx and php-fpm
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
