FROM richarvey/nginx-php-fpm:latest

# 1. Install Node.js and NPM (Required for Vite/Mix)
RUN apk add --no-cache nodejs npm

COPY . .

# 2. Build Frontend Assets (The "npm run build" step)
RUN npm ci --no-audit
RUN npm run build

# Image config
ENV SKIP_COMPOSER 0
ENV ERRORS 1
ENV RUN_SCRIPTS 1
ENV REAL_IP_HEADER 1
ENV COMPOSER_ALLOW_SUPERUSER 1

CMD ["/start.sh"]