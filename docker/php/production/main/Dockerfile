ARG BASE_IMAGE

FROM $BASE_IMAGE

COPY . .

RUN chown -R 33:33 storage/
RUN chown -R 33:33 bootstrap/cache/

RUN composer install --no-scripts

ENV PHP_OPCACHE_VALIDATE_TIMESTAMPS="0" \
    PHP_OPCACHE_MAX_ACCELERATED_FILES="10000" \
    PHP_OPCACHE_MEMORY_CONSUMPTION="192" \
    PHP_OPCACHE_MAX_WASTED_PERCENTAGE="10" \
    PHP_APM_ENABLED="false" \
    PHP_APM_SERVER_URL="http://localhost:8200" \
    PHP_APM_SECRET_TOKEN="" \
    PHP_APM_SERVICE_NAME="Service"

COPY .docker/php/production/main/php.ini "$PHP_INI_DIR/"
COPY .docker/php/production/main/elastic_apm.ini /usr/local/etc/php/conf.d/
COPY .docker/php/production/main/www.conf /usr/local/etc/php-fpm.d/www.conf
COPY .docker/php/production/main/docker-php-entrypoint /usr/local/bin/
RUN chmod 755 /usr/local/bin/docker-php-entrypoint
