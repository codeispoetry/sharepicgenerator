up:
	docker-compose up -d

stop:
	docker-compose stop

build:
	docker-compose up --build -d

install:
	docker-compose run grunt sh -c 'npm install'

grunt-shell:
	docker-compose exec grunt bash

compile:
	docker-compose exec grunt grunt build

compileJS:
	docker-compose exec grunt grunt buildJS

log:
	docker-compose logs -f grunt

shell:
	docker-compose exec webserver bash

down:
	docker-compose down

deploy:
	docker-compose exec webserver bash /root/scripts/deploy.sh

get-config:
    rsync tom@sharepicgenerator.de:/var/www/html/config.* code/dist/.

get-log:
	rsync tom@sharepicgenerator.de:/var/www/html/log/log.log code/dist/log.log

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

