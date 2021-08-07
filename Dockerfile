FROM php:8.0.8-apache

RUN apt-get update
RUN apt-get install libzip-dev libpng-dev  -y
RUN apt-get update && apt-get install -y zlib1g-dev 

RUN docker-php-ext-install pdo pdo_mysql zip mysqli && a2enmod rewrite
RUN docker-php-ext-install gd
# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY ./admin /var/www/html

WORKDIR /var/www/html

RUN composer install

RUN chmod -R 775 /var/www/html/storage/

RUN chown -R www-data:www-data /var/www/html/storage/