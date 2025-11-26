# Stage 1 - Build Frontend (Vite)
FROM node:18 AS frontend
WORKDIR /app
COPY package*.json ./

# FIX: Force a clean npm install to resolve the rollup/native optional dependency bug.
RUN npm cache clean --force && \
    rm -rf node_modules package-lock.json && \
    npm install

COPY . .
RUN npm run build

# Stage 2 - Backend (Laravel + PHP + Composer)
FROM php:8.2-fpm AS backend

# 1. INSTALL SYSTEM DEPENDENCIES (Nginx dan Supervisord DITAMBAHKAN)
RUN apt-get update && apt-get install -y \
    git curl unzip libpq-dev libonig-dev libzip-dev zip \
    nginx supervisor ca-certificates \
    && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_mysql mbstring zip

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Configure PHP-FPM to listen on TCP instead of socket
RUN echo "listen = 127.0.0.1:9000" >> /usr/local/etc/php-fpm.d/zz-docker.conf

# 2. KONFIGURASI NGINX DAN SUPERVISOR
# Hapus default Nginx dan tambahkan konfigurasi Laravel
RUN rm /etc/nginx/sites-enabled/default
COPY ./.docker/nginx/default.conf /etc/nginx/sites-available/default.conf
RUN ln -s /etc/nginx/sites-available/default.conf /etc/nginx/sites-enabled/default

# Tambahkan konfigurasi Supervisord untuk menjalankan PHP-FPM dan Nginx
COPY ./.docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Copy app files (excluding node_modules and vendor via .dockerignore)
COPY --chown=www-data:www-data . .

# Copy built frontend from Stage 1 and verify
COPY --from=frontend --chown=www-data:www-data /app/public/build ./public/build
RUN echo "Verifying Vite build files:" && \
    ls -la public/build/ && \
    if [ ! -f "public/build/manifest.json" ]; then \
        echo "ERROR: manifest.json not found!"; \
        exit 1; \
    fi && \
    echo "manifest.json found successfully"

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Set permissions for Laravel storage/cache
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache && \
    chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# Create startup script
COPY ./.docker/start.sh /start.sh
RUN chmod +x /start.sh

# Expose port 80
EXPOSE 80

# 3. Use startup script to run Laravel commands and supervisord
CMD ["/start.sh"]