up:
	docker-compose up -d

stop:
	docker-compose stop

restart-node:
	docker-compose restart node

build:
	docker-compose up --build -d &&	chmod 777 code/dist/log/ code/dist/persistent/user/ code/dist/tmp/

install:
	docker-compose run node sh -c 'npm install'

node-shell:
	docker-compose exec node bash

compile:
	docker-compose exec node npm run build:dev

production-compile:
	docker-compose exec node npm run build:production

log:
	docker-compose logs -f --tail 20 node

shell:
	docker-compose exec webserver bash

down:
	docker-compose down

checkstyle:
	phpcs -s code/dist/

fixstyle:
	phpcbf code/dist/

phplint:
	docker run -it --rm overtrue/phplint:latest

composer-install:
	composer install

deploy-develop:
	php vendor/bin/dep deploy develop

deploy-production:
	php vendor/bin/dep deploy production

rollback:
	php vendor/bin/dep rollback production

clean:
	rm code/dist/tmp/* -rf

eslint:
	cd code && npx eslint build --ext .js,.jsx,.ts,.tsx

log-get:
	rsync --progress sharepic:/var/www/sharepicgenerator.de/shared/log/logs/log.db code/dist/log/logs/log.db

log-shell:
	docker-compose exec webserver sqlite3 dist/log/logs/log.db

user-get:
	rsync --progress sharepic:/var/www/sharepicgenerator.de/shared/log/logs/user.db code/dist/log/logs/user.db

users:
	docker-compose exec webserver sqlite3 dist/log/logs/user.db

watch:
	docker-compose exec node npm run watch

tenant-create:
	@read -p "new tenant name: " tenant; \
	./scripts/create-tenant.sh $$tenant \
	make compile

tenant-delete:
	@read -p "which tenant do you want to delete: " tenant; \
	./scripts/delete-tenant.sh $$tenant \
	make compile
