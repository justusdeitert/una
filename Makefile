DOCKER_COMPOSE:=docker compose -f docker-compose.yml

install: .STOP .BUILD .START

start: .START

stop: .STOP

enter: .ENTER

enter_phpmyadmin: .ENTER_PHPMYADMIN

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

.ENTER:
	@$(DOCKER_COMPOSE) exec -w / php /bin/sh

.ENTER_PHPMYADMIN:
	@$(DOCKER_COMPOSE) exec -w / phpmyadmin /bin/sh
