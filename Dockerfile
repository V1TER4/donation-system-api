FROM php:8.4-fpm

RUN docker-php-ext-install pdo pdo_mysql

COPY . /var/www/html/donation-api

WORKDIR /var/www/html/

EXPOSE 9000
