FROM php:8.2.5-fpm

RUN apt-get update && apt-get install -y git curl zip unzip libpq-dev

# install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# install pdo
RUN docker-php-ext-install pdo pdo_pgsql && docker-php-ext-enable pdo pdo_pgsql

# enable OPcache
RUN docker-php-ext-install opcache && docker-php-ext-enable opcache
COPY ./config/opcache.ini "${PHP_INI_DIR}/conf.d"

# install xdebug
RUN pecl install xdebug && docker-php-ext-enable xdebug
COPY ./config/xdebug.ini "${PHP_INI_DIR}/conf.d"

WORKDIR /var/www/symfony
