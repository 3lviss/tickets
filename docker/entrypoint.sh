#!/bin/bash
set -e

echo "Starting setup..."

# Install PHP dependencies
echo "Installing Composer dependencies..."
composer install --no-interaction --prefer-dist --optimize-autoloader

# Install Node dependencies and build assets
echo "Installing Node dependencies..."
npm install

echo "Building assets..."
npm run build

# Setup environment
if [ ! -f .env ]; then
    echo "Creating .env file..."
    cp .env.example .env
fi

# Generate app key if not set
echo "Generating application key..."
grep -q "^APP_KEY=base64:" .env || php artisan key:generate --force

# Create SQLite database if it doesn't exist
if [ ! -f database/database.sqlite ]; then
    echo "Creating SQLite database..."
    touch database/database.sqlite
fi

# Run migrations and seed
echo "Running migrations..."
php artisan migrate --force --seed

echo "Setup complete!"
echo "Application running at http://localhost:8000"

# Start the server
php artisan serve --host=0.0.0.0 --port=8000