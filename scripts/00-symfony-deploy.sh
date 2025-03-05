#!/usr/bin/env bash
echo "Running composer"
composer install --no-dev --optimize-autoloader

echo "Caching config..."
APP_ENV=prod APP_DEBUG=0 php bin/console cache:clear

echo "Creating database if does not exists..."
APP_ENV=prod APP_DEBUG=0 php bin/console doctrine:database:create --if-not-exists

echo "Running database migrations..."
APP_ENV=prod APP_DEBUG=0 php bin/console doctrine:migrations:migrate --no-interaction

echo "Checking and creating users if needed..."
APP_ENV=prod APP_DEBUG=0 php bin/console app:create-users
