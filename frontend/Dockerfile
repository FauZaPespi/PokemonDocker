FROM php:apache

RUN docker-php-ext-install pdo pdo_mysql

COPY ./ressource/ /var/www/html/

EXPOSE 80
