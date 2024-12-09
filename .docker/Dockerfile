FROM php:fpm

RUN curl -sS https://get.symfony.com/cli/installer | bash
RUN mv /root/.symfony5/bin/symfony /usr/local/bin/symfony

WORKDIR /var/www

EXPOSE 9000

CMD ["php-fpm"]