#!/usr/bin/env bash
echo "Running composer"
composer install --no-dev --optimize-autoloader

echo "Caching config..."
APP_ENV=prod APP_DEBUG=0 php bin/console cache:clear

echo "Creating database..."
APP_ENV=prod APP_DEBUG=0 php bin/console doctrine:database:create --if-not-exists

echo "Migrating database..."
APP_ENV=prod APP_DEBUG=0 php bin/console doctrine:migrations:migrate --no-interaction

echo "Loading sample data..."
APP_ENV=prod APP_DEBUG=0 php bin/console app:create-users
APP_ENV=prod APP_DEBUG=0 php bin/console app:create-feedback
APP_ENV=prod APP_DEBUG=0 php bin/console app:create-comments
APP_ENV=prod APP_DEBUG=0 php bin/console app:create-upvotes
