# Stage 1 - Build Frontend (Vite)
FROM node:18 AS frontend
WORKDIR /app
COPY package*.json ./

# FIX: Force a clean npm install to resolve the rollup/native optional dependency bug.
# The error "Cannot find module @rollup/rollup-linux-x64-gnu" often points to an
# issue where optional native dependencies were improperly installed/linked by npm.
# We explicitly clean up residual files and re-run the install for stability.
RUN npm cache clean --force && \
    rm -rf node_modules package-lock.json && \
    npm install

COPY . .
RUN npm run build

# Stage 2 - Backend (Laravel + PHP + Composer)
FROM php:8.2-fpm AS backend

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git curl unzip libpq-dev libonig-dev libzip-dev zip \
    && docker-php-ext-install pdo pdo_mysql mbstring zip

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Copy app files
COPY . .

# Copy built frontend from Stage 1. Preserving user's configured output path.
COPY --from=frontend /app/public/build ./public/dist

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader
    
# Laravel setup
RUN php artisan config:clear && \
    php artisan route:clear && \
    php artisan view:clear

CMD ["php-fpm"]