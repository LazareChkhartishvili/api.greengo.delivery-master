#!/bin/bash
set -e

# Debug all database-related environment variables
echo "=== Database Environment Variables ==="
echo "DATABASE_URL=$DATABASE_URL"
echo "PGHOST=$PGHOST"
echo "PGPORT=$PGPORT" 
echo "PGDATABASE=$PGDATABASE"
echo "PGUSER=$PGUSER"
echo "DB_CONNECTION=$DB_CONNECTION"
echo "DB_HOST=$DB_HOST"
echo "DB_PORT=$DB_PORT"
echo "DB_DATABASE=$DB_DATABASE"
echo "DB_USERNAME=$DB_USERNAME"
echo "====================================="

# If DATABASE_URL exists, parse it and set individual variables
if [ ! -z "$DATABASE_URL" ]; then
    echo "Parsing DATABASE_URL..."
    # Extract components from DATABASE_URL
    export DB_CONNECTION=pgsql
    export DB_HOST=$(echo $DATABASE_URL | sed 's/.*@\([^:]*\):.*/\1/')
    export DB_PORT=$(echo $DATABASE_URL | sed 's/.*:\([0-9]*\)\/.*/\1/')
    export DB_DATABASE=$(echo $DATABASE_URL | sed 's/.*\/\([^?]*\).*/\1/')
    export DB_USERNAME=$(echo $DATABASE_URL | sed 's/.*:\/\/\([^:]*\):.*/\1/')
    export DB_PASSWORD=$(echo $DATABASE_URL | sed 's/.*:\/\/[^:]*:\([^@]*\)@.*/\1/')
    
    echo "Parsed DATABASE_URL:"
    echo "DB_HOST=$DB_HOST"
    echo "DB_PORT=$DB_PORT"
    echo "DB_DATABASE=$DB_DATABASE"
    echo "DB_USERNAME=$DB_USERNAME"
fi

# Wait for database to be ready
echo "Waiting for database..."
sleep 10

# Run database migrations
echo "Running database migrations..."
php artisan migrate --force

# Clear and cache config for production
echo "Optimizing Laravel..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Start Apache
echo "Starting Apache..."
exec apache2-foreground
