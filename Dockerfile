FROM php:8.2-fpm AS base
WORKDIR /var/www
RUN apt-get update && apt-get install -y libpng-dev libjpeg-dev libfreetype6-dev git unzip libzip-dev && \
    docker-php-ext-configure zip && \
    docker-php-ext-install gd zip pdo pdo_mysql && \
    pecl install xdebug && \
    docker-php-ext-enable xdebug
COPY composer.json composer.lock /var/www/
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer install --no-autoloader --no-scripts
COPY . /var/www
RUN composer install --optimize-autoloader --no-dev
EXPOSE 9000
CMD ["php-fpm"]
