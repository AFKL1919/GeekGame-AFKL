FROM php:7.4-apache
COPY flag.png /flag.png

COPY html /var/www/html
RUN \
    chmod -R 755 /var/www/html &&\
	chmod 444 /flag.png
