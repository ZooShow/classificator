ARG PHP_VERSION=8.0
ARG ALPINE_VERSION=3.15
FROM php:${PHP_VERSION}-fpm-alpine${ALPINE_VERSION}

RUN docker-php-ext-install pdo_mysql  \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /srv