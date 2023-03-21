FROM php:8.1-fpm-alpine

RUN apt-get update && apt-get isntall -y \
    git \
    curl \
    zip \
    vim \
    unzip

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN docker-php-exe-install pdo pdo_mysql

WORkDIR /var/www