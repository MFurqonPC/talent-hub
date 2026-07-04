#!/bin/sh
set -e

# Tunggu MySQL siap dulu (kadang container app start duluan sebelum db ready)
echo "Menunggu database siap..."
until php -r "new PDO('mysql:host=$DB_HOST;port=$DB_PORT', '$DB_USERNAME', '$DB_PASSWORD');" 2>/dev/null; do
    sleep 1
done
echo "Database siap."

# Generate APP_KEY otomatis kalau belum ada
if [ -z "$APP_KEY" ]; then
    php artisan key:generate --force
fi

# Cache config, route, view supaya Laravel tidak perlu parse ulang tiap request
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Jalankan migrasi otomatis (aman dipanggil berkali-kali, skip yang sudah jalan)
php artisan migrate --force

exec php-fpm
