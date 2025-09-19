#!/usr/bin/env bash
# Render start script for Laravel

set -o errexit

# Run database migrations
php artisan migrate --force

# Start the Laravel server
php artisan serve --host=0.0.0.0 --port=$PORT
