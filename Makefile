init: docker-down-clear docker-pull docker-build docker-up composer-install wait-db migrations
up: docker-up
down: docker-down
restart: down up
check: lint analyze test

docker-up:
	docker-compose up -d

docker-down:
	docker-compose down --remove-orphans

docker-down-clear:
	docker-compose down -v --remove-orphans

docker-pull:
	docker-compose pull

docker-build:
	docker-compose build

composer-install:
	docker-compose run --rm cli composer install

wait-db:
	docker compose run --rm cli wait-for-it db:3306 -t 30

migrations:
	docker-compose run --rm cli php yii migrate --interactive=0

lint:
	docker-compose run --rm cli composer lint
	docker-compose run --rm cli composer cs-check

cs-fix:
	docker-compose run --rm cli composer cs-fix

analyze:
	docker-compose run --rm cli composer phpstan

test:
	docker-compose run --rm cli composer test
