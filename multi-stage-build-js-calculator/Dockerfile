FROM node:25-alpine3.21 AS builder

WORKDIR /app

COPY . .

RUN npm i && npm run build

FROM nginx:trixie AS app

COPY --from=builder /app/dist /usr/share/nginx/html