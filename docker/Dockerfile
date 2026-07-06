# ===================== STAGE 1: Build asset frontend (Tailwind/Vite) =====================
FROM node:20-alpine AS node-builder

WORKDIR /app
COPY package*.json vite.config.js tailwind.config.js postcss.config.js ./
RUN npm install

COPY resources/ resources/
RUN npm run build

# ===================== STAGE 2: PHP-FPM + Composer =====================
FROM php:8.2-fpm

# Dependency sistem yang dibutuhkan Laravel
RUN apt-get update && apt-get install -y \
    git curl zip unzip \
    libpng-dev libonig-dev libxml2-dev libzip-dev \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Copy source code project
COPY . .

# Copy hasil build asset dari stage node (folder public/build hasil Vite)
COPY --from=node-builder /app/public/build ./public/build

# Install dependency PHP (production, tanpa dev dependency)
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Aktifkan OPcache (percepat eksekusi PHP, hilangkan overhead compile ulang tiap request)
COPY docker/opcache.ini /usr/local/etc/php/conf.d/opcache.ini

# Entrypoint: cache config Laravel, migrate, baru jalankan php-fpm
COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

# Permission folder storage & cache
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache \
    && chmod -R 775 /var/www/storage /var/www/bootstrap/cache

RUN echo "upload_max_filesize=3M" >> /usr/local/etc/php/conf.d/uploads.ini \
    && echo "post_max_size=4M" >> /usr/local/etc/php/conf.d/uploads.ini

EXPOSE 9000
ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
