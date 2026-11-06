# --- Stage 1: Compile Frontend Assets ---
FROM node:20-alpine AS frontend-builder
WORKDIR /app
COPY package*.json ./
RUN npm ci
COPY . .
RUN npm run build

# --- Stage 2: Production PHP Web Server ---
FROM serversideup/php:8.4-fpm-nginx

# Switch to root temporarily to configure files
USER root

# Set the working directory
WORKDIR /var/www/html

# Copy application files
COPY --chown=www-data:www-data . /var/www/html

# Copy the compiled Vite assets from Stage 1
COPY --from=frontend-builder --chown=www-data:www-data /app/public/build /var/www/html/public/build

# Install dependencies (including dev tools for Faker)
RUN composer install --no-interaction --prefer-dist --no-scripts
RUN composer dump-autoload --optimize

# NATIVE FREE-TIER AUTOMATION HOOK
# Creates a startup script that runs migrations and seeds securely in the image engine lifecycle
RUN mkdir -p /etc/entrypoint.d && \
    echo "#!/bin/sh" > /etc/entrypoint.d/99-laravel-setup.sh && \
    echo "cd /var/www/html" >> /etc/entrypoint.d/99-laravel-setup.sh && \
    echo "php artisan migrate:fresh --force" >> /etc/entrypoint.d/99-laravel-setup.sh && \
    echo "php artisan db:seed --force" >> /etc/entrypoint.d/99-laravel-setup.sh && \
    chmod +x /etc/entrypoint.d/99-laravel-setup.sh

# Switch back to secure user
USER www-data