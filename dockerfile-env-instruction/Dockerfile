FROM php:8.4-cli

ENV APP_NAME="Simple Application" APP_DEBUG=false

WORKDIR /var/www/html

COPY --chmod=u+x index.php .

ENTRYPOINT [ "php" ]

CMD [ "./index.php" ]