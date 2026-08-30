#!/usr/bin/env bash
# Install PHP Dependencies
composer install --no-dev --working-dir=/var/www/html

# Install NPM Dependencies & Build Assets (CSS/JS)
npm install
npm run build

# Clear & Cache Laravel Configurations
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Run Migrations & Seeders
php artisan migrate --force
php artisan db:seed --force
