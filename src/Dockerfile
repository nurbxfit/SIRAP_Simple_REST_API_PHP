FROM php:8.0-fpm

RUN apt-get update
RUN docker-php-ext-install pdo pdo_mysql

WORKDIR /usr/share/nginx/html/

COPY --chown=1000:1000 . .

# For file upload
# RUN chown -R 33:33 .
# RUN chmod -R 755 ./images/profile/