FROM php:8.3-fpm-alpine

RUN apk add --no-cache git unzip curl \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && composer --version

WORKDIR /var/www/html
COPY . /var/www/html/

EXPOSE 9000
CMD ["php-fpm"]
