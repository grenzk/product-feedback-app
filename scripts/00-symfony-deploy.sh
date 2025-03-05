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
USER_COUNT=$(APP_ENV=prod APP_DEBUG=0 php bin/console dbal:run-sql "SELECT COUNT(*) FROM \"user\"" --quiet)
if [ "$USER_COUNT" -eq "0" ]; then
    echo "Creating initial users..."
    APP_ENV=prod APP_DEBUG=0 php bin/console app:create-users
else
    echo "Users already exist, skipping creation..."
fi
