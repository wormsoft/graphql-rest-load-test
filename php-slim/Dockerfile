FROM php:7-alpine

RUN apk --no-cache add php7-dev \
	&&pecl install memcached \
    && docker-php-ext-enable memcached
