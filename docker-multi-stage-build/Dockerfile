FROM composer:2 AS build

WORKDIR /app

COPY ./composer.json ./composer.lock .

RUN composer install

FROM php:8.4-cli AS final

WORKDIR /var/www/html

COPY --from=build /app/vendor/ ./vendor/

COPY ./index.php .

RUN mkdir uploads \
    && chown www-data:www-data uploads\
    && chmod 755 uploads 

VOLUME [ "/var/www/html/uploads" ]

EXPOSE 8000

CMD [ "php", "-S", "0.0.0.0:8000" ]