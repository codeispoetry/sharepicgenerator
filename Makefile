up:
	docker-compose up -d

stop:
	docker-compose stop

build:
	docker-compose up --build -d &&	chmod 777 code/dist/log/ code/dist/persistent/user/ code/dist/tmp/ code/dist/tenants/federal/gallery/img/

install:
	docker-compose run node sh -c 'npm install'

node-shell:
	docker-compose exec node bash

compile:
	docker-compose exec node npm run build:dev

log:
	docker-compose logs -f node

shell:
	docker-compose exec webserver bash

down:
	docker-compose down

get-config:
	docker-compose exec webserver rsync rsync tom@sharepicgenerator.de:/var/www/html/ini/* ini/

get-log:
	docker-compose exec webserver rsync tom@sharepicgenerator.de:/var/www/html/log/log.log dist/log.log

get-passwords:
	docker-compose exec webserver rsync tom@sharepicgenerator.de:/var/www/html/passwords.php dist/passwords.php

test:
	cd tests && SELENIUM_REMOTE_URL="http://localhost:4444/wd/hub" ENV=local node test.js

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

deploy-rollback:
	php vendor/bin/dep deploy production
