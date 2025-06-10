init:
	docker-compose -f docker/docker-compose.yml run --rm app composer install \
 		&& docker-compose -f docker/docker-compose.yml run --rm app npm install \
 		&& docker-compose -f docker/docker-compose.yml run --rm app php artisan key:generate \
 		&& docker-compose -f docker/docker-compose.yml run --rm app php artisan migrate \
 		&& docker-compose -f docker/docker-compose.yml run --rm app php artisan db:seed

up:
	docker-compose -f docker/docker-compose.yml up -d

down:
	docker-compose -f docker/docker-compose.yml down

migrate:
	docker-compose -f docker/docker-compose.yml exec app php artisan migrate

test:
	docker-compose -f docker/docker-compose.yml exec app php artisan test

exec:
	docker-compose -f docker/docker-compose.yml exec app bash

cs-sniff:
	docker-compose -f docker/docker-compose.yml exec app composer sniff

cs-lint:
	docker-compose -f docker/docker-compose.yml exec app composer lint

code-analyze:
	docker-compose -f docker/docker-compose.yml exec app composer larastan-analyze

swagger-generate:
	docker-compose -f docker/docker-compose.yml exec app php artisan l5-swagger:generate
