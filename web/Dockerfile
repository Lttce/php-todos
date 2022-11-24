FROM php:8.0-apache

COPY --from=composer:2.4 /usr/bin/composer /usr/bin/composer 

RUN apt-get update && \
    apt-get install -y --no-install-recommends \
        zip \
        unzip && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/* && \
    docker-php-ext-install pdo_mysql
