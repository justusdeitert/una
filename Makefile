DOCKER_COMPOSE := docker compose

.PHONY: install start stop build_container clean_install enter_php enter_phpmyadmin enter_node dev build analyze setup_wordpress export_db import_db

install: stop build_container start
clean_install: stop clean build_container start

start:
	@$(DOCKER_COMPOSE) up -d

stop:
	@$(DOCKER_COMPOSE) down

build_container:
	@$(DOCKER_COMPOSE) build

clean:
	@$(DOCKER_COMPOSE) down -v
	@docker network prune -f

enter_php:
	@$(DOCKER_COMPOSE) exec -w /var/www/html php /bin/zsh

enter_phpmyadmin:
	@$(DOCKER_COMPOSE) exec -w / phpmyadmin /bin/sh

enter_node:
	@$(DOCKER_COMPOSE) exec -w /usr/src/theme node /bin/zsh

dev:
	@$(DOCKER_COMPOSE) exec -w /usr/src/theme node yarn dev

build:
	@$(DOCKER_COMPOSE) exec -w /usr/src/theme node yarn build

analyze:
	@$(DOCKER_COMPOSE) exec -e ANALYZE=1 -w /usr/src/theme node yarn build
	@open theme/stats.html
	@sleep 2 && rm -f theme/stats.html

setup_wordpress:
	@$(DOCKER_COMPOSE) exec php /usr/local/bin/setup-wordpress.sh

export_db:
	@$(DOCKER_COMPOSE) exec php /usr/local/bin/search-replace-export-db.sh

import_db:
	@$(DOCKER_COMPOSE) exec php /usr/local/bin/search-replace-import-db.sh