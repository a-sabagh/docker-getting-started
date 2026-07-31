FROM php:8.4-cli

WORKDIR /var/www/html

COPY ./favicon.ico ./index.php .

ENTRYPOINT [ "php" ]

CMD [ "-S", "0.0.0.0:80" ]

EXPOSE 80