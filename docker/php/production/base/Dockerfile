FROM php:8.0-fpm

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
    && docker-php-ext-install opcache

RUN mkdir -p /home/apm-agent && \
    cd /home/apm-agent && \
    git clone https://github.com/elastic/apm-agent-php.git apm && \
    cd apm/src/ext && \
    /usr/local/bin/phpize && ./configure --enable-elastic_apm && \
    make clean && make && make install && cp elastic_apm.ini /usr/local/etc/php/conf.d/elastic_apm.ini

WORKDIR /app

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
     && php composer-setup.php --install-dir=/usr/bin --filename=composer \
     && php -r "unlink('composer-setup.php');"

COPY ./composer.json ./composer.lock ./

RUN composer install --no-autoloader --no-scripts

ADD ./.docker/php/production/base/cronjobs /etc/cron.d/cronjobs

RUN chmod 0644 /etc/cron.d/cronjobs && \
    crontab /etc/cron.d/cronjobs && \
    touch /var/log/cron.log
