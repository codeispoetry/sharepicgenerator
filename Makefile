up:
	docker-compose up -d

stop:
	docker-compose stop

build:
	docker-compose up --build -d &&	chmod 777 code/dist/log/ code/dist/persistent/user/ code/dist/tmp/

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

tests:
	docker-compose exec webserver python tests/test-federal.py
	docker-compose exec webserver python tests/test-bayern.py
	docker-compose exec webserver python tests/test-vintage.py

test-federal:
	docker-compose exec webserver python tests/test-federal.py

test-vintage:
	docker-compose exec webserver python tests/test-vintage.py

test-bayern:
	docker-compose exec webserver python tests/test-bayern.py

test-live:
	docker-compose exec webserver python tests/test-live.py

doc:
	docker-compose exec mkdocs mkdocs build

