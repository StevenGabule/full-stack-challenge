FROM php:8.1-zts-bullseye

ENV COMPOSER_ALLOW_SUPERUSER 1

# Copy in files
COPY . /user/src/otto
WORKDIR /user/src/otto

# Install Mysql
RUN apt-get update && apt-get install -y default-mysql-client make p7zip zip unzip
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

EXPOSE 8080

CMD composer install --ignore-platform-reqs && php -S 0.0.0.0:8080 -t public
