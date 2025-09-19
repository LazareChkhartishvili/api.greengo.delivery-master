#!/usr/bin/env bash
# Render build script for Laravel

set -o errexit

# Install PHP dependencies
composer install --no-dev --optimize-autoloader

# Cache Laravel configuration
php artisan config:cache

# Cache routes
php artisan route:cache

# Cache views
php artisan view:cache

echo "Build completed successfully!"
