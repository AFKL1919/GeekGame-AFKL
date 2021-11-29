FROM php:5.4-fpm

COPY ./sources.list /etc/apt/sources.list

RUN \
	echo "nameserver 223.5.5.5" >> /etc/resolv.conf && \
	apt-get update && \
        apt-get install -y nginx

COPY ./default /etc/nginx/sites-available/default
COPY ./nginx.conf /etc/nginx/nginx.conf
COPY ./start.sh /start.sh

COPY ./flag /flag

CMD ["bash", "/start.sh"]
