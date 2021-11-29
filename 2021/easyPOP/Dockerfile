FROM php:fpm

COPY flag /flag

COPY html /var/www/html
RUN \
    chmod -R 755 /var/www/html &&\
	chmod 444 /flag

WORKDIR /var/www/html
USER www-data

CMD ["php", "-S", "0.0.0.0:80"]