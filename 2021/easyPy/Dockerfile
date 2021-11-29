FROM python:alpine

RUN \
	pip install -i https://pypi.tuna.tsinghua.edu.cn/simple flask &&\
    adduser -S www-data -G www-data

COPY ./flag /flag
COPY ./app /app

RUN \
    chmod -R 755 /app &&\
	chmod 444 /flag

USER www-data

CMD ["python", "/app/app.py"]