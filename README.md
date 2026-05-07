# Laravel Docker Dev/Prod Setup

## Структура проекта

```
.
├── src/                        # Laravel-приложение
├── docker/
│   ├── nginx/
│   │   └── default.conf
│   └── php/
│       ├── Dockerfile          # Multistage: base → dev / prod
│       ├── php.ini
│       ├── xdebug.ini
│       └── php-fpm.conf
├── .env                        # Инфраструктура: порты хоста
├── .env.example
├── docker-compose.yml          # Dev-окружение
├── docker-compose.prod.yml     # Production-оверрайды
└── Makefile
```

## Переменные окружения

| Файл       | Назначение                                         |
|------------|----------------------------------------------------|
| `.env`     | Порты хоста (`NGINX_PORT`, `MYSQL_PORT`)           |
| `src/.env` | Laravel: `APP_KEY`, подключение к БД, кэш, почта  |

## Быстрый старт (dev)

### 1. Настрой порты (при необходимости)

Если порты по умолчанию заняты, отредактируй `.env` перед запуском:

```dotenv
NGINX_PORT=8080
MYSQL_PORT=3306
```

### 2. Настрой приложение

Создай `src/.env` из примера и задай нужные значения:

```bash
cp src/.env.example src/.env
```

### 3. Запусти установку

```bash
make install
```

Команда выполнит всё необходимое:
- скопирует `.env`-файлы из примеров (если ещё не существуют)
- соберёт Docker-образы
- запустит контейнеры
- выставит права на `storage/` и `bootstrap/cache/`
- сгенерирует `APP_KEY` (только если не задан)
- выполнит миграции

Команду безопасно повторять — на уже развёрнутом проекте она ничего не сломает.

### 4. Открой браузер

```
http://localhost:8080
```

---

## Полезные команды

```bash
make up               # запустить контейнеры
make down             # остановить и удалить контейнеры
make restart          # перезапустить контейнеры
make shell            # sh в PHP-контейнере
make logs             # следить за логами
make ps               # статус контейнеров
make migrate          # выполнить миграции
make migrate-fresh    # сбросить БД и накатить с сидерами
make composer c='require package/name'
make artisan c='make:controller Foo'
```

---

## Xdebug

Включён в dev-образе, порт `9003`. В IDE укажи `host.docker.internal` как хост отладчика.

---

## Production

```bash
make prod-up
```

Оверрайды из `docker-compose.prod.yml`:

- PHP собирается с target `prod`: нет Xdebug, `composer install --no-dev`, код запечён в образ
- Порт MySQL не пробрасывается на хост

---

## Требования

- Docker >= 24
- Docker Compose v2
