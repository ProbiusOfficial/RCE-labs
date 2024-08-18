FROM php:7.3-apache


WORKDIR /var/www/html

COPY *.php /var/www/html/

# 重新设置源码路径的用户所有权
RUN chown -R www-data:www-data /var/www/html
RUN mkdir -p /var/log/apache2 && \
    chown -R www-data:www-data /var/log/apache2


COPY entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/entrypoint.sh


COPY ./configs/apache2.conf /etc/apache2/apache2.conf
COPY ./configs/app.conf /etc/apache2/sites-enabled/000-default.conf
COPY ./configs/php.ini  /usr/local/etc/php/conf.d/custom.ini


ENTRYPOINT ["entrypoint.sh"]


CMD ["apache2-foreground"]
