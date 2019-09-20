up:
	docker-compose up -d

build:
	docker-compose up --build -d

install:
	docker-compose run grunt sh -c 'npm install'

grunt-shell:
	docker-compose exec grunt bash

shell:
	docker-compose exec webserver bash

down:
	docker-compose down
