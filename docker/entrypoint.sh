#!/usr/bin/env sh
set -eu

cd /var/www/html

mkdir -p \
    storage/logs \
    storage/framework/cache/data \
    storage/framework/sessions \
    storage/framework/views \
    bootstrap/cache \
    database

touch database/database.sqlite
chown -R www-data:www-data storage bootstrap/cache database

# Prevent stale local cache files (e.g. dev package manifest) from breaking production boot.
rm -f bootstrap/cache/*.php

run_as_www_data() {
    su -s /bin/sh www-data -c "$*"
}

run_as_www_data "php artisan package:discover --ansi --no-interaction"

if [ "${RUN_MIGRATIONS:-true}" = "true" ]; then
    run_as_www_data "php artisan migrate --force --no-interaction"
fi

if [ "${APP_ENV:-production}" = "production" ]; then
    run_as_www_data "php artisan config:cache"
    run_as_www_data "php artisan view:cache"
fi

exec "$@"
