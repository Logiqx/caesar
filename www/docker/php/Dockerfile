ARG PHP_VERSION
ARG ALPINE_VERSION
FROM php:${PHP_VERSION:+${PHP_VERSION}-}fpm-alpine${ALPINE_VERSION}

COPY log.conf /usr/local/etc/php-fpm.d/zz-log.conf

RUN docker-php-ext-install mysqli
