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
