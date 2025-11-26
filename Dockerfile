# --- STAGE 1: FRONTEND BUILDER (Uses compatible Node image) ---
# We use a standard Node image where rollup/native dependencies won't fail
FROM node:18-slim AS frontend-builder
WORKDIR /app

# Install dependencies and build assets
COPY package.json package-lock.json ./
RUN npm ci --no-audit --no-optional
COPY . .
RUN npm run build

# --- STAGE 2: FINAL SERVER IMAGE ---
FROM richarvey/nginx-php-fpm:latest
# Set working directory to the web root
WORKDIR /var/www/html

# 1. Copy PHP/Composer dependencies from your local project
COPY . .

# 2. Copy ONLY the *compiled* assets from Stage 1
# This skips the build failure issue entirely
COPY --from=frontend-builder /app/public/build public/build

# 3. Copy node_modules (Optional, but safer for runtime utilities)
COPY --from=frontend-builder /app/node_modules node_modules


# Image config (Keep your existing ENV vars)
ENV SKIP_COMPOSER 0
ENV ERRORS 1
ENV RUN_SCRIPTS 1
ENV REAL_IP_HEADER 1
ENV COMPOSER_ALLOW_SUPERUSER 1

CMD ["/start.sh"]