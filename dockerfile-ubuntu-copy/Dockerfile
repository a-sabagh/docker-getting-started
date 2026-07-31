FROM ubuntu:latest

COPY --chmod=ugo+x ./log-whoami.sh /home/ubuntu/

WORKDIR /home/ubuntu/

COPY --chmod=+x ./gm.php .

RUN apt update && apt install php -y

USER ubuntu

CMD ["./gm.php"]