FROM php:8.1-fpm

WORKDIR /app

RUN export CFLAGS="$PHP_CFLAGS" CPPFLAGS="$PHP_CPPFLAGS" LDFLAGS="$PHP_LDFLAGS" \
    && apt-get update \
    && apt-get install -y --no-install-recommends \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libmcrypt-dev \
        libpng-dev \
        libicu-dev \
        libpq-dev \
        libxpm-dev \
        libvpx-dev \
        libgmp-dev \
        libmagickwand-dev \
        libzip-dev \
        unzip \
        git \
        cron \
        curl \
        imagemagick \
        libcurl4-openssl-dev \
    && rm -rf /var/lib/apt/lists/* \
    && ln -s /usr/include/x86_64-linux-gnu/gmp.h /usr/local/include/ \
    && pecl install -o -f imagick \
    && docker-php-ext-enable imagick \
    && docker-php-ext-configure gmp  \
    && docker-php-ext-install gmp \
    && docker-php-ext-install bcmath \
    && docker-php-ext-install -j$(nproc) zip \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-install -j$(nproc) intl \
    && docker-php-ext-install -j$(nproc) zip \
    && docker-php-ext-install -j$(nproc) pgsql \
    && docker-php-ext-install -j$(nproc) pdo_pgsql \
    && docker-php-ext-install -j$(nproc) exif \
    && docker-php-ext-configure gd \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install opcache \
    && docker-php-ext-install sockets

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php --install-dir=/usr/bin --filename=composer \
    && php -r "unlink('composer-setup.php');"

ADD crontab /etc/cron.d/cronjobs
RUN ls /etc/cron.d/

ADD php.ini /usr/local/etc/php/

RUN apt-get update && apt-get install -y cron && \
    chmod 0644 /etc/cron.d/cronjobs && \
    crontab /etc/cron.d/cronjobs && \
    touch /var/log/cron.log

RUN pecl install xdebug && docker-php-ext-enable xdebug
ADD xdebug.ini /usr/local/etc/php/conf.d/

RUN apt-get -y update && apt-get -y install build-essential autoconf libcurl4-openssl-dev --no-install-recommends

