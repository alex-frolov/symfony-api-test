# Инициализация проекта через докер.
См. README.md в папке docker

### 0. Редактирвоанеи /etc/hosts
Добавляем 
```bash
127.0.0.1 api.loc
```

### 1. Подготовить `env`
```bash
cp .env.test .env
```
отредактировать созданный `.env` под свои параметры системы.
Там проверить сторку по доступу к БД, если ничего не менялось в docker/docker-compose.yml, то менять ничего не надо.

### 2. Запускаем миграции.
```bash
cd docker
make bash
php bin/console cache:clear
php bin/console doctrine:migrations:migrate
```

### 2. Запускаем тесты.
```bash
make bash
php ./vendor/phpunit/phpunit/phpunit
```
---
## Примеры запросов

Добавление автора
```bash
curl -H 'Host: api.loc:8081' -H 'content-type: application/x-www-form-urlencoded; charset=utf-8' --data-binary "name=My_first_test_author" --compressed 'http://api.loc:8081/author/create'
```

Добавление книги:

```bash
curl -H 'Host: api.loc:8081' -H 'content-type: application/x-www-form-urlencoded; charset=utf-8' --data-binary "names[en]=My_first_book&names[ru]=моя_первая_книга&authorId=2" --compressed 'http://api.loc:8081/book/create'
```

Поиск книги:
```bash
curl 'http://api.loc:8081/ru/books/search/43731638208527' -X 'GET'
```

```bash
curl 'http://api.loc:8081/en/books/search/43731638208527' -X 'GET'
````
