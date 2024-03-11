up:
	docker-compose up -d

build:
	docker-compose build

down:
	docker-compose down

ps:
	docker-compose ps

shell:
	docker-compose exec app bash

dev:
	docker-compose exec app npm run dev

npm-build:
	docker-compose exec app npm run build

migrate:
	docker-compose exec app php artisan migrate

routes:
	docker-compose exec app php artisan route:list
