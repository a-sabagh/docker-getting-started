FROM php:8.2-apache

RUN apt update

RUN apt install -y libzip-dev

RUN docker-php-ext-install zip

CMD [ "apache2-foreground" ]