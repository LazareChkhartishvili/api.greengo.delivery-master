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

# Check if DATABASE_URL is properly set (not a template)
if [ ! -z "$DATABASE_URL" ] && [[ "$DATABASE_URL" != *"\${{DATABASE_URL}}"* ]]; then
    echo "Valid DATABASE_URL found, parsing..."
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
elif [[ "$DATABASE_URL" == *"\${{DATABASE_URL}}"* ]]; then
    echo "ERROR: DATABASE_URL template not substituted by Render!"
    echo "This means PostgreSQL database is not properly connected to the service."
    echo "Please check Render Dashboard:"
    echo "1. Create a PostgreSQL database"
    echo "2. Connect it to your web service"
    echo "3. Verify DATABASE_URL environment variable is set"
    exit 1
else
    echo "No DATABASE_URL found, using individual DB variables..."
    if [ -z "$DB_HOST" ] && [ -z "$PGHOST" ]; then
        echo "ERROR: No database connection variables found!"
        echo "Please set either DATABASE_URL or individual DB_* variables"
        exit 1
    fi
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
