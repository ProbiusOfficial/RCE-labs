FROM php:8.2.12-cli-alpine

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

COPY ./docker-entrypoint.sh /docker-entrypoint.sh
RUN chmod +x /docker-entrypoint.sh

WORKDIR /app

COPY ./index.php ./
ADD pages ./pages/


RUN composer require smarty/smarty symfony/symfony

COPY ./openbdir.ini /usr/local/etc/php/conf.d/openbdir.ini

ENTRYPOINT ["/docker-entrypoint.sh"]
