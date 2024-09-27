FROM php:8.3-fpm

# Update image packages
RUN apt-get update -y && apt-get install -y nginx

# Add Docker PHP Extensions
RUN docker-php-ext-install pdo_mysql \
    && docker-php-ext-install opcache \
    && apt-get install libicu-dev -y \
    && docker-php-ext-configure intl \
    && docker-php-ext-install intl \
    && apt-get remove libicu-dev icu-devtools -y
RUN { \
        echo 'opcache.memory_consumption=128'; \
        echo 'opcache.interned_strings_buffer=8'; \
        echo 'opcache.max_accelerated_files=4000'; \
        echo 'opcache.revalidate_freq=2'; \
        echo 'opcache.fast_shutdown=1'; \
        echo 'opcache.enable_cli=1'; \
    } > /usr/local/etc/php/conf.d/php-opocache-cfg.ini

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy files
COPY docker/api/nginx.conf /etc/nginx/sites-enabled/default
COPY docker/api/entrypoint.sh /etc/entrypoint.sh
COPY api /var/www/api

# Install app dependencies
WORKDIR /var/www/api
RUN composer install

# Expose required ports
EXPOSE 80

# Specify entrypoint
ENTRYPOINT ["sh", "/etc/entrypoint.sh"]