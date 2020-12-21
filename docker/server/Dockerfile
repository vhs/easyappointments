FROM php:7.4-apache AS build

ARG DEBIAN_FRONTEND=noninteractive

WORKDIR "/var/www/html"

COPY . .

RUN apt-get update && apt-get install -y \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    zip \
    unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd gettext mysqli pdo_mysql

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename composer \
    && composer update

RUN curl -sL https://deb.nodesource.com/setup_14.x | bash - \
    && apt update \
    && apt-get install -y nodejs \
    && npm install \
    && npm run build

FROM php:7.4-apache

ARG DEBIAN_FRONTEND=noninteractive

WORKDIR "/var/www/html"

COPY --from=build /var/www/html/build .

RUN rm CHANGELOG.md LICENSE README.md composer.json

RUN apt-get update && apt-get install -y \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    zip \
    unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd gettext mysqli pdo_mysql

RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

COPY docker/server/php.ini /usr/local/etc/php/conf.d/99-overrides.ini
RUN a2enmod rewrite

RUN chmod 1777 storage/backups storage/cache storage/logs storage/sessions storage/uploads

VOLUME [ "/var/www/html/storage" ]
