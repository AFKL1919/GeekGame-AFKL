FROM ubuntu

RUN echo "nameserver 223.5.5.5" >> /etc/resolv.conf

COPY ./app /app
COPY ./flag /flag

RUN \
    chmod -R 555 /app && \
    chown -R www-data:www-data /app && \
    chmod 444 /flag

USER www-data
WORKDIR /app

# I wrote such a code in main.go. `webapp.Static("/static", "./")`
CMD ["/app/geek"]