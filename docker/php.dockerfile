FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    vim \
    unzip \
    libicu-dev

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

RUN docker-php-ext-configure intl
RUN docker-php-ext-install pdo pdo_mysql intl

RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

COPY env/xdebug.ini "${PHP_INI_DIR}/conf.d"

WORKDIR /var/www

