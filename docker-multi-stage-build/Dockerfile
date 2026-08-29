FROM composer:2 AS dev-dependencies

WORKDIR /app

COPY ./composer.json ./composer.lock .

RUN composer install \
    --no-interaction

FROM php:8.4-apache AS development

WORKDIR /var/www/html

COPY --from=dev-dependencies /app/vendor/ ./vendor/

COPY --from=dev-dependencies /usr/bin/composer /usr/bin/composer

COPY . .

VOLUME [ "/var/www/html/index.php" ]

RUN mkdir uploads \
    && chown www-data:www-data uploads\
    && chmod 755 uploads 

FROM composer:2 AS prod-dependencies

WORKDIR /app

COPY ./composer.json ./composer.lock .

RUN composer install \
    --no-interaction \
    --no-dev \
    --optimize-autoloader

FROM php:8.4-apache AS production

WORKDIR /var/www/html

COPY --from=prod-dependencies /app/vendor/ ./vendor/

COPY ./index.php .

RUN mkdir uploads \
    && chown www-data:www-data uploads\
    && chmod 755 uploads 

VOLUME [ "/var/www/html/uploads" ]