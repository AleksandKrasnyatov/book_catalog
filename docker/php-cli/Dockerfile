FROM php:8.5-cli-alpine

RUN apk add --no-cache bash netcat-openbsd mysql-client
RUN apk add --no-cache --virtual .build-deps \
        $PHPIZE_DEPS \
        mariadb-dev \
    && docker-php-ext-install -j$(nproc) mysqli pdo_mysql \
    && apk del .build-deps

COPY ./wait-for-it.sh /usr/local/bin/wait-for-it
RUN chmod 555 /usr/local/bin/wait-for-it

# установка composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY ./conf.d /usr/local/etc/php/conf.d

WORKDIR /app
