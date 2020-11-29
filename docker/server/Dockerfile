FROM node:14 as node
WORKDIR /app
COPY package.json .
COPY gulpfile.js .
RUN npm install

FROM php:7.4-apache

WORKDIR "/var/www/html"
COPY --from=node /app ./
ARG DEBIAN_FRONTEND=noninteractive

RUN apt-get update && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
        zip \
        unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd gettext mysqli pdo_mysql

COPY composer.json .
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename composer
RUN composer update

RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

COPY index.php .
COPY config-sample.php ./config.php
COPY docker/server/php.ini /usr/local/etc/php/conf.d/99-overrides.ini
RUN a2enmod rewrite
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer
RUN composer update
RUN curl -sL https://deb.nodesource.com/setup_13.x | bash - \
      && apt-get install -y nodejs
RUN npm install
