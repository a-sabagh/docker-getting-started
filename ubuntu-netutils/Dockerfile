FROM ubuntu:latest

LABEL org.opencontainers.image.authors="Abolfazl M. Sabagh<info@asabagh.ir>"
LABEL description="Ubuntu Image with recommended net utitlities"
LABEL init_date="Jun 28 2026"

RUN apt update && \
    apt install -y --no-install-recommends \
    iputils-ping \
    iproute2 \
    traceroute \
    netcat-openbsd \
    dnsutils \
    curl \
    wget

RUN apt clean && \
    rm -rf /var/lib/lists/*

WORKDIR /home/ubuntu

CMD [ "/bin/bash" ]