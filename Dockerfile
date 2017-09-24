FROM alpine:3.6

RUN apk update

RUN apk add --no-cache php7 \
    php7-curl \
    php7-json \
    php7-mbstring \
    php7-xml \
    php7-xdebug \
    php7-ctype \
    php7-session \
    php7-phar \
    php7-tokenizer \
    php7-zlib \
    php7-dom \
    php7-posix \
    php7-openssl

RUN sed -ie 's/^;zend/zend/' /etc/php7/conf.d/xdebug.ini

RUN apk add curl
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer
RUN export COMPOSER_DISABLE_XDEBUG_WARN=1

CMD ["php", "-a"]
