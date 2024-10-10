# Install app dependencies
FROM composer/composer:latest AS app_install

COPY api /app
WORKDIR /app
RUN composer install

FROM vladerc/fpm-nginx:latest

# Copy files
COPY docker/api/nginx.conf /etc/nginx/sites-enabled/default
COPY docker/api/entrypoint.sh /etc/entrypoint.sh

# Install app dependencies
WORKDIR /var/www/app

# Expose required ports
EXPOSE 80

# Install app dependencies
WORKDIR /var/www/app
COPY --from=app_install /app /var/www/app

# Specify entrypoint
ENTRYPOINT ["sh", "/etc/entrypoint.sh"]