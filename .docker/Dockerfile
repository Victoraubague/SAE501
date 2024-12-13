FROM php:8.4-fpm

WORKDIR /var/www

COPY ../symfony/composer.json ./

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    && docker-php-ext-install pdo pdo_mysql

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY /.docker/php/conf.d/ /usr/local/etc/php/conf.d/

RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

RUN apt-get update && apt-get install -y \
    libpng-dev \
    && docker-php-ext-configure gd \
    && docker-php-ext-install gd

RUN pecl install pcov \
    && docker-php-ext-enable pcov

#symfony
EXPOSE 9000
#xdebug
EXPOSE 9003

CMD ["php-fpm"]