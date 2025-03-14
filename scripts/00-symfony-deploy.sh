#!/usr/bin/env bash
echo "Running composer"
composer install --no-dev --optimize-autoloader

echo "Caching config..."
php bin/console cache:clear

echo "Creating database..."
php bin/console doctrine:database:create --if-not-exists

echo "Migrating database..."
php bin/console doctrine:migrations:migrate --no-interaction

echo "Loading sample data..."
php bin/console app:create-users
php bin/console app:create-feedback
php bin/console app:create-comments
