FROM php:7.4-fpm as php
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
    libzip-dev \
    unzip \
    && docker-php-ext-install pdo_mysql \
    && docker-php-ext-install intl \
    && docker-php-ext-install sockets \
    && docker-php-ext-install soap \
    && docker-php-ext-install pdo_pgsql \
    && docker-php-ext-install zip \
    && docker-php-ext-install opcache


ADD php.ini /usr/local/etc/php/conf.d/40-custom.ini
ADD opcache.ini /usr/local/etc/php/conf.d/opcache.ini

WORKDIR /var/www

# Добавим своего локального пользователя - решаем проблемы с доступами к файлам и их генерацией в докере и извне.
ARG UID=${UID}
ARG UNAME=${UNAME}
ARG UPASS=${UPASS}
ARG WORKING_DIR=${WORKING_DIR}

ENV LANG=ru_RU.UTF-8 \
	LC_ALL=ru_RU.UTF-8 \
	LANGUAGE=ru_RU.UTF-8 \
	COMPOSER_ALLOW_SUPERUSER=1 \
	COMPOSER_HOME=/tmp

COPY --from=composer /usr/bin/composer /usr/bin/composer

#RUN echo "en_US.UTF-8 UTF-8" >> /etc/locale.gen && \
#	echo "ru_RU.UTF-8 UTF-8" >> /etc/locale.gen && \
#	locale-gen && \
#	cp /usr/share/zoneinfo/Europe/Moscow /etc/localtime && \
#	echo "Moscow/Europe" > /etc/timezone
#
#
#RUN adduser --quiet --disabled-password --gecos "First Last,Room Number,Work Phone,Home Phone" -u ${UID} ${UNAME}
#RUN adduser --quiet ${UNAME} www-data
#RUN echo ${UNAME}:${UPASS} | chpasswd
#RUN usermod -aG sudo ${UNAME}

# Запускаем контейнер
CMD ["php-fpm"]
