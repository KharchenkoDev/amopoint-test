ifneq (,$(wildcard ./.env))
    include .env
    export
endif

NGINX_PORT ?= 8080

DOCKER_COMP = docker compose

PHP_EXEC = $(DOCKER_COMP) exec php
PHP_RUN  = $(DOCKER_COMP) run --rm php

PHP      = $(PHP_EXEC) php
COMPOSER = $(PHP_EXEC) composer
ARTISAN  = $(PHP) artisan

.DEFAULT_GOAL := help
.PHONY: help install build up down stop start restart shell logs ps permissions \
        composer composer-install artisan key-generate migrate migrate-fresh \
        test \
        cs cs-fix \
        prod-up prod-down

## —— 🐘 Laravel Docker Makefile ———————————————————————————————————————————————
help: ## Вывести эту справку
	@awk 'BEGIN {FS = ":.*?## "} /^[a-zA-Z0-9][a-zA-Z0-9_-]+:.*?## / { printf "\033[36m%-20s\033[0m %s\n", $$1, $$2 } /^## .*$$/ { printf "\033[33m%s\033[0m\n", substr($$0, 4) }' $(MAKEFILE_LIST)

## —— Setup ————————————————————————————————————————————————————————————————————
install: ## Полная установка для dev-режима; безопасно повторять на уже инициализированном проекте
	@test -f .env     || (cp .env.example .env         && echo "Создан .env (infrastructure)")
	@test -f src/.env || (cp src/.env.example src/.env && echo "Создан src/.env (application)")
	@$(DOCKER_COMP) build
	@$(DOCKER_COMP) up --detach --wait
	@$(MAKE) permissions --no-print-directory
	@grep -q "^APP_KEY=base64:" src/.env 2>/dev/null || $(ARTISAN) key:generate
	@$(ARTISAN) migrate --no-interaction

## —— Docker ———————————————————————————————————————————————————————————————————
build: ## Собрать Docker-образы
	@$(DOCKER_COMP) build

up: ## Запустить контейнеры в фоне
	@$(DOCKER_COMP) up --detach
	@echo "You can now access the application at http://localhost:$(NGINX_PORT)"

down: ## Остановить и удалить контейнеры
	@$(DOCKER_COMP) down --remove-orphans

stop: ## Остановить контейнеры (без удаления)
	@$(DOCKER_COMP) stop

start: ## Запустить остановленные контейнеры
	@$(DOCKER_COMP) start

restart: stop start ## Перезапустить контейнеры

shell: ## Открыть sh в PHP-контейнере
	@$(PHP_EXEC) sh

logs: ## Следить за логами контейнеров
	@$(DOCKER_COMP) logs -f

ps: ## Статус контейнеров
	@$(DOCKER_COMP) ps

permissions: ## Выставить права на storage/ и bootstrap/cache/
	@$(PHP_EXEC) chown -R www-data:www-data storage bootstrap/cache
	@$(PHP_EXEC) chmod -R ug+rwX storage bootstrap/cache

## —— Composer 🧙 ——————————————————————————————————————————————————————————————
composer: ## Запустить Composer; передай команду через c=, например: make composer c='require laravel/sanctum'
	@$(eval c ?=)
	@$(COMPOSER) $(c)

composer-install: ## Установить зависимости Composer
	@$(COMPOSER) install

## —— Laravel ——————————————————————————————————————————————————————————————————
artisan: ## Запустить artisan; передай команду через c=, например: make artisan c='make:controller Foo'
	@$(eval c ?=)
	@$(ARTISAN) $(c)

key-generate: ## Сгенерировать APP_KEY
	@$(ARTISAN) key:generate

migrate: ## Выполнить миграции
	@$(ARTISAN) migrate

migrate-fresh: ## Сбросить БД и накатить миграции с сидерами
	@$(ARTISAN) migrate:fresh --seed

## —— Tests ————————————————————————————————————————————————————————————————————
test: ## Запустить тесты
	@$(ARTISAN) test

## —— Code Quality —————————————————————————————————————————————————————————————
cs: ## Проверить стиль кода (без изменений)
	@$(PHP_EXEC) vendor/bin/php-cs-fixer fix --dry-run --diff

cs-fix: ## Исправить стиль кода
	@$(PHP_EXEC) vendor/bin/php-cs-fixer fix

## —— Production ———————————————————————————————————————————————————————————————
prod-up: ## Запустить в production-режиме (target=prod, --build)
	@$(DOCKER_COMP) -f docker-compose.yml -f docker-compose.prod.yml up --detach --build

prod-down: ## Остановить production-контейнеры
	@$(DOCKER_COMP) -f docker-compose.yml -f docker-compose.prod.yml down
