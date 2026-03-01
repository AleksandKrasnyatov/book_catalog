FROM php:8.5-fpm-alpine

RUN apk add --no-cache --virtual .build-deps \
        $PHPIZE_DEPS \
        mariadb-dev \
    && docker-php-ext-install -j$(nproc) mysqli pdo_mysql \
    && apk del .build-deps \
    && apk add --no-cache mysql-client

COPY ./conf.d /usr/local/etc/php/conf.d

WORKDIR /app

CMD ["php-fpm"]
