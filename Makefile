DC := docker-compose -f docker-compose.local.yml
EXEC := $(DC) exec api
DR := $(DC) run --rm

SYMFONY := $(EXEC) php bin/console

.DEFAULT_GOAL: help
.PHONY: help
help: ## Affiche cette aide
	@grep -E '(^[a-zA-Z_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[32m%-10s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'

## --- Docker 🐳 ---

.PHONY: up
up: ## Démarre les conteneurs
	$(DC) up -d

.PHONY: down
down: ## Stoppe les conteneurs
	$(DC) down

.PHONY: build
build: ## Construit les images des conteneurs
	$(DC) build

## --- Projet 🐘 ---

.PHONY: init
init: ## Initialise le projet
	$(EXEC) composer install --no-interaction --prefer-dist
	$(EXEC) npm install

.PHONY: start
start: ## Démarre le serveur de développement
	$(EXEC) npm run dev
	$(EXEC) symfony server:start

.PHONY: stop
stop: ## Arrêter  le serveur de développement
	$(EXEC) symfony server:stop

.PHONY: shell
shell: ## Lance un shell bash
	$(EXEC) bash

## --- Symfony 🧙‍♂️ ---


.PHONY: dump
dump: ## Affiche les modifications de BD en attente
	$(SYMFONY) d:s:u --dump-sql

.PHONY: migrations
migrations: ## Génère les migrations par rapport aux modèles
	$(SYMFONY) make:migration

.PHONY: migrate
migrate: ## Lance l'insertion des migrations en BDD
	$(SYMFONY) doctrine:migrations:migrate --no-interaction

.PHONY: force
force: ## Met à jour la base de donnée via le Dsu
	$(SYMFONY) d:s:u --force

.PHONY: database
database: ## Recrée une base de données
	$(SYMFONY) doctrine:database:drop --force --if-exists
	$(SYMFONY) doctrine:database:create

.PHONY: fixtures
fixtures: ## Ajout des fixtures
	$(SYMFONY) doctrine:fixtures:load

