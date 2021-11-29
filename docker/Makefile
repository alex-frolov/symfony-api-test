UNAME=$(shell uname)
USERID=$(shell id -u)
GROUPID=$(shell id -g)
DOCKERUSER="$(USERID):$(GROUPID)"
DOCKER_RUN_OPTS=-u $(DOCKERUSER) --rm -it
COMPOSER_IMAGE=composer:2.0.3
PHP_DEV_IMAGE=php-custom:7.4-fpm-buster

ifeq ($(UNAME), Linux)
	USERGROUP:=$(shell getent group $(GROUPID) | cut -d: -f1)
endif

ifeq ($(UNAME), Darwin)
	USERGROUP=staff
endif

.env:
	cp .env.dist .env

.PHONY: .env

init: docker-build docker-up app-init

up: docker-build docker-up

down:
	docker-compose down

docker-build:
	docker-compose build

docker-up:
	docker-compose up -d

app-init:
	docker-compose run --rm cli composer install

bash:
	docker-compose exec cli bash
