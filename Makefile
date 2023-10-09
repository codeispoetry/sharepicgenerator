up:
	docker-compose up -d

stop:
	docker-compose stop

restart-node:
	docker-compose restart node

build:
	docker-compose up --build -d &&	chmod 777 code/dist/log/ code/dist/persistent/user/ code/dist/tmp/

node-shell:
	docker-compose run node bash

shell:
	docker-compose exec webserver bash

down:
	docker-compose down

deploy-develop:
	php vendor/bin/dep deploy develop

deploy-production:
	php vendor/bin/dep deploy production

rollback:
	php vendor/bin/dep rollback production

clean:
	rm code/dist/tmp/* -rf

log-get:
	rsync --progress sharepic:/var/www/sharepicgenerator.de/shared/log/logs/log.db code/dist/log/logs/log.db

log-shell:
	docker-compose exec webserver sqlite3 dist/log/logs/log.db

user-get:
	rsync --progress sharepic:/var/www/sharepicgenerator.de/shared/log/logs/user.db code/dist/log/logs/user.db

users:
	docker-compose exec webserver sqlite3 dist/log/logs/user.db

test-delete-screenshots:
	rm code/tests/screenshots.spec.js-snapshots/* && \
	rm code/tests/create-sharepic.spec.js-snapshots/*

test:
	npx playwright test

tenant-create:
	@read -p "new tenant name: " tenant; \
	./scripts/create-tenant.sh $$tenant btw21 \
	make compile

tenant-free-create:
	@read -p "new free tenant name: " tenant; \
	./scripts/create-tenant.sh $$tenant einigungshilfe \
	make compile

tenant-delete:
	@read -p "which tenant do you want to delete: " tenant; \
	./scripts/delete-tenant.sh $$tenant \
	make compile

compile:
	docker-compose run node gulp build --gulpfile gulpfile.js

make-woff:
	woff2_compress in/container/my/font.ttf
