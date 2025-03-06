#!/usr/bin/env bash
echo "Running composer"
composer install --no-dev --optimize-autoloader

echo "Caching config..."
APP_ENV=prod APP_DEBUG=0 php bin/console cache:clear

echo $SSL_ROOT_CERT | base64 --decode > '/tmp/root.crt'

echo "Creating database if does not exists..."
APP_ENV=prod APP_DEBUG=0 php bin/console doctrine:database:create --if-not-exists

echo "Running database migrations..."
APP_ENV=prod APP_DEBUG=0 php bin/console doctrine:migrations:migrate --no-interaction

echo "Creating users..."
APP_ENV=prod APP_DEBUG=0 php bin/console app:create-users
