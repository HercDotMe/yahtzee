# Install app dependencies
FROM composer/composer:latest as app_install

COPY api /app
WORKDIR /app
RUN composer install

FROM vladerc/fpm-nginx:latest

# Copy files
COPY docker/api/nginx.conf /etc/nginx/sites-enabled/default
COPY docker/api/entrypoint.sh /etc/entrypoint.sh
COPY api /var/www/api

# Install app dependencies
WORKDIR /var/www/api

# Expose required ports
EXPOSE 80

# Install app dependencies
WORKDIR /var/www/api
COPY --from=app_install /app /var/www/api

# Specify entrypoint
ENTRYPOINT ["sh", "/etc/entrypoint.sh"]