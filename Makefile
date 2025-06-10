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
