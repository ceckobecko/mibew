FROM php:7.3-apache
RUN apt-get update && apt-get install -y libpng-dev
RUN docker-php-ext-install pdo pdo_mysql gd

