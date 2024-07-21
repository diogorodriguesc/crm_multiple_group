FROM php:8.3-fpm

COPY php.ini /usr/local/etc/php/conf.d/

RUN apt-get update

RUN apt-get -y install git

RUN pecl install apcu-5.1.23

RUN docker-php-ext-install pdo pdo_mysql opcache

RUN docker-php-ext-enable apcu

RUN curl --insecure https://getcomposer.org/composer.phar -o /usr/bin/composer && chmod +x /usr/bin/composer

# Set timezone
RUN rm /etc/localtime
RUN ln -s /usr/share/zoneinfo/Europe/Berlin /etc/localtime
RUN "date"

WORKDIR /var/www/application

# RUN sh /var/www/application/bin/run_startup.sh
# CMD ["bin/run_startup.sh"]
