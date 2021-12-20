FROM ghcr.io/damlys/phpdock:sdk-8.1.0

ENV VERSION="0.1.2"

ENV APP_ENV="prod"
ENV APP_DEBUG="0"
COPY ./app /app

RUN composer install \
&& composer clear-cache \
&& chmod --recursive a+r /app \
&& chmod --recursive a+x /app/bin/* \
&& chown --recursive www-data:www-data /app/var \
&& chmod --recursive a+w /app/var

USER www-data:www-data
