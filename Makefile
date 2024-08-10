DOCKER_COMPOSE:=docker compose -f docker-compose.yml

install: .STOP .BUILD .START

start: .START

stop: .STOP

enter_php: .ENTER_PHP

enter_phpmyadmin: .ENTER_PHPMYADMIN

enter_node: .ENTER_NODE

build: .BUILD

clean_install: .STOP .CLEAN .BUILD .START

.BUILD:
	@$(DOCKER_COMPOSE) build

.START:
	@$(DOCKER_COMPOSE) up -d

.STOP:
	@$(DOCKER_COMPOSE) down

.CLEAN:
	@docker network prune -f

.ENTER_PHP:
	@$(DOCKER_COMPOSE) exec -w /var/www/html php /bin/zsh

.ENTER_PHPMYADMIN:
	@$(DOCKER_COMPOSE) exec -w / phpmyadmin /bin/sh

.ENTER_NODE:
	@$(DOCKER_COMPOSE) exec -w /usr/src/theme node /bin/zsh