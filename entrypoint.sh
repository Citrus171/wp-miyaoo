#!/bin/bash
set -e

cd /var/www/html

if [ ! -d "vendor" ]; then
    echo "[Bedrock] Running composer install..."
    composer install --no-dev --optimize-autoloader
fi

mkdir -p web/app/uploads
chmod -R o+rX /var/www/html 2>/dev/null || true
chown -R www-data:www-data web/app/uploads 2>/dev/null || true

exec "$@"
