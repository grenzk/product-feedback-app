# Stage 1: Build the Vue.js frontend
FROM node:22-alpine AS frontend-build
WORKDIR /app
COPY package*.json .
RUN npm install
COPY ./assets ./assets
COPY vite.config.ts tsconfig*.json .
RUN npm run build

# Stage 2: Build the Symfony backend
FROM richarvey/nginx-php-fpm:latest

COPY . .
COPY --from=frontend-build /app/public/build /var/www/html/public/build

# Image config
ENV SKIP_COMPOSER=1
ENV WEBROOT=/var/www/html/public
ENV PHP_ERRORS_STDERR=1
ENV RUN_SCRIPTS=1
ENV REAL_IP_HEADER=1

# Symfony config
ENV APP_ENV=prod
ENV APP_DEBUG=0

ENV COMPOSER_ALLOW_SUPERUSER=1

CMD ["/start.sh"]
