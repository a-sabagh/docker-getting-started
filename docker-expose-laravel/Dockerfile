FROM php:8.4-cli

RUN apt update \
    && apt install -y curl \
    && rm -rf /var/lib/apt/lists/*

HEALTHCHECK --interval=5s --timeout=30s --start-period=5s --retries=3 \
    CMD [ "curl", "-fsSL", "127.0.0.1:8000/health" ]

WORKDIR /var/www/html

COPY . .

EXPOSE 8000

CMD [ "php", "artisan", "serve", "--host", "0.0.0.0", "--port", "8000" ]