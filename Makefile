up:
	docker-compose up -d

up-test:
	docker-compose -f docker-compose.yml -f docker-compose.test.yml up -d	

stop:
	docker-compose stop

restart-node:
	docker-compose restart node

build:
	docker-compose up --build -d &&	chmod 777 code/dist/log/ code/dist/persistent/user/ code/dist/tmp/ code/dist/tenants/federal/gallery/img/

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

test:
	cd tests && URL=http://webserver LOCAL=true python3 test.py

test-live:
	cd tests && URL=https://sharepicgenerator.de LOCAL=true python3 test.py

test-develop:
	cd tests && URL=https://develop.sharepicgenerator.de LOCAL=true python3 test.py

test-tenant:
	@read -p "which tenant (e.g. bw,rlp,hessen,frankfurt): " tenant; \
	cd tests && URL=http://webserver TENANT=$$tenant LOCAL=true python3 tenant.py

test-tenants:
	cd tests && URL=http://webserver TENANT=bw LOCAL=true python3 tenant.py && \
	URL=http://webserver TENANT=hessen LOCAL=true python3 tenant.py && \
	URL=http://webserver TENANT=rlp LOCAL=true python3 tenant.py && \
	URL=http://webserver TENANT=frankfurt LOCAL=true python3 tenant.py

doc:
	docker-compose exec mkdocs mkdocs build

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

bw-templates-get:
	rsync -av sharepic:/var/www/sharepicgenerator.de/shared/tenants/bw/gallery/img/ code/dist/tenants/bw/gallery/img

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