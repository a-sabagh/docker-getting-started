FROM php:8.4-cli

VOLUME [ "/root" ]

COPY --chmod=u+x docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh

COPY --chmod=u+x phonebook.php /usr/local/bin/phonebook

ENTRYPOINT [ "docker-entrypoint.sh" ]

CMD [ "phonebook" ]