FROM php:8.2-apache
RUN apt-get update && apt-get install -y \
    libpq-dev \
    && rm -rf /var/lib/apt/lists/*
#WORKDIR /var/www/html
#COPY . /var/www/html
RUN docker-php-ext-install pdo_pgsql
RUN a2enmod rewrite
EXPOSE 80