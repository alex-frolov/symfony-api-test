FROM php:7.4-cli as php
USER ${UNAME}

RUN ln -snf /usr/share/zoneinfo/${TZ} /etc/localtime && echo ${TZ} > /etc/timezone

RUN apt-get update && apt-get install -y \
    git \
    libmcrypt-dev \
	libicu-dev \
    libpq-dev \
    build-essential \
    chrpath \
    libssl-dev \
	curl \
    libxml2-dev \
    iputils-ping \
    libzip-dev \
    unzip \
    && docker-php-ext-install pdo_mysql \
    && docker-php-ext-install intl \
    && docker-php-ext-install sockets \
    && docker-php-ext-install soap \
    && docker-php-ext-install pdo_pgsql \
    && docker-php-ext-install zip \
    && docker-php-ext-install opcache

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer --version=1.10.16
RUN composer global require hirak/prestissimo

ADD php.ini /usr/local/etc/php/conf.d/40-custom.ini

# Алиас, вместо "php bin/console some:command" можно просто "c some:command"
RUN echo 'alias c="php bin/console"' >> ~/.bashrc

# Указываем рабочую директорию для PHP
WORKDIR /var/www
ENV LANG=ru_RU.UTF-8 \
	LC_ALL=ru_RU.UTF-8 \
	LANGUAGE=ru_RU.UTF-8 \
	COMPOSER_ALLOW_SUPERUSER=1 \
	COMPOSER_HOME=/tmp

COPY --from=composer /usr/bin/composer /usr/bin/composer