ARG VERSION

FROM php:${VERSION} AS dev

ENV APP_ENV=dev

## Install system dependencies
RUN apk update && \
    apk add --no-cache --virtual dev-deps git autoconf gcc g++ make icu-dev && \
    apk add --no-cache zlib-dev libzip-dev postgresql-dev linux-headers 

## Install php extensions
RUN pecl install xdebug && \
    docker-php-ext-enable xdebug && \
    docker-php-ext-configure intl && \
    docker-php-ext-install pdo pdo_pgsql zip intl

COPY --chown=1000:1000 ./app /app

WORKDIR /app

## Install composer
RUN wget https://getcomposer.org/installer && \
    php installer --install-dir=/usr/local/bin/ --filename=composer && \
    rm installer

FROM dev AS prod

ENV APP_ENV=prod

WORKDIR /app

## Remove dev dependencies
RUN composer install --no-dev --no-interaction --optimize-autoloader

RUN chown -R www-data:www-data .

## Disable xdebug and composer on production
RUN rm /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN rm /usr/local/bin/composer
