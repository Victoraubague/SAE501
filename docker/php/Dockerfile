# image PHP
FROM php:8.2-fpm

#  dépendances nécessaires
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libicu-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libzip-dev \
    curl \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
        intl \
        gd \
        mbstring \
        pdo_mysql \
        zip \
        opcache

# Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

#  php.ini personnalisé
COPY php.ini /usr/local/etc/php/php.ini

#  répertoire de travail
WORKDIR /var/www/html
