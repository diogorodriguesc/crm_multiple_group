#!/usr/bin/env bash

set -ex

DIR=$(dirname "$0")
cd $DIR/..

echo "Executing startup..."

echo "Installing dependencies..."
composer install

echo "Creating databases"
bin/console doctrine:database:create --if-not-exists
bin/console doctrine:database:create --if-not-exists --env test

echo "Installing migrations..."
bin/console doctrine:migrations:migrate -n
bin/console doctrine:migrations:migrate -n --env test

echo "Run startup script finished."
