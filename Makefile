SHELL = bash
PROJECT_NAME = aoc2022

run:
	mkdir log || true
	mkdir temp || true
	docker kill $$(docker ps -q) || true
	docker-compose up -d
	docker exec -it aoc composer install

bash:
	docker exec -it aoc bash

stop:
	docker-compose down
