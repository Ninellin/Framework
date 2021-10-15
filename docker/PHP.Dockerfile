FROM php:fpm AS production

WORKDIR /Framework
RUN docker-php-ext-install pdo pdo_mysql
COPY . /Framework

FROM production AS dev
RUN pecl install xdebug && docker-php-ext-enable xdebug
