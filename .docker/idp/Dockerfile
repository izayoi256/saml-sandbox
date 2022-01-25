FROM php:7.4.12-apache-buster

COPY --from=composer:2.2.4 /usr/bin/composer /usr/bin/composer

RUN set -x \
    && apt-get update  \
    && apt-get install -y --no-install-recommends \
        git \
        iproute2 \
        libzip-dev \
        sudo \
        unzip \
    && docker-php-ext-install \
        bcmath \
        zip \
    && chown www-data:www-data /var/www \
    && apt-get clean

RUN a2enmod rewrite

COPY base.ini /usr/local/etc/php/conf.d/base.ini
COPY entrypoint-base.sh /entrypoint-base.sh

RUN set -x \
    && pecl install \
        xdebug-3.1.2 \
    && docker-php-ext-enable \
        xdebug

COPY dev.ini /usr/local/etc/php/conf.d/dev.ini
COPY entrypoint-dev.sh /entrypoint-dev.sh
ENTRYPOINT ["/entrypoint-dev.sh"]
CMD ["apache2-foreground"]
