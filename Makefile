DOCKER_COMPOSE:=docker compose -f docker-compose.yml

install: .STOP .BUILD .START

start: .START

stop: .STOP

enter: .ENTER

build: .BUILD

.BUILD:
	@$(DOCKER_COMPOSE) build

.START:
	@$(DOCKER_COMPOSE) up -d

.STOP:
	@$(DOCKER_COMPOSE) stop

.ENTER:
	@$(DOCKER_COMPOSE) exec php-fpm /bin/sh