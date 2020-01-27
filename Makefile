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

test:
	docker-compose exec webserver python tests/test.py

