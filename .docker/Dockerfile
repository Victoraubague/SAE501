FROM php:fpm

WORKDIR /var/www

#copie synfony/composer.json
COPY ../symfony/composer.json ./
#install composer
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    && docker-php-ext-install pdo pdo_mysql

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

EXPOSE 9000

CMD ["php-fpm"]