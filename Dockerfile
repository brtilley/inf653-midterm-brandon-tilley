FROM php:docker.io/dpage/pgadmin4:9.1.0

RUN apt-get update && apt-get install -y \
    libpq-dev \
    && rm -rf /var/lib/apt/lists/*

# WORKDIR /var/www/html

# COPY . /var/www.html

RUN docker-php-ext-install pdo_pgsql

# COPY apache.conf /etc/apache2/sites-available/000-default.conf

# RUN a2enmod rewrite
# RUN echo "Listen 0.0.0.0:80" >> /etc/apache2/apache2.conf

