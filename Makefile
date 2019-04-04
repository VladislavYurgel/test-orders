include .env

help:
	@echo ""
	@echo "usage: make <COMMAND>"
	@echo ""
	@echo "Commands:"
	@echo "   init-project		Init project"
	@echo "   composer-update	Update packages via composer"
	@echo "   composer-install	Install packages via composer"
	@echo "   docker-start		Create and start containers"
	@echo "   docker-stop		Stop all running containers"
	@echo "   test			Running the project tests"
	@echo "   code-sniff		Check code via PHP Code Sniffer (PSR2)"

init-project:
	@echo "Trying to init project..."
	@docker-compose run composer create-project --prefer-dist laravel/laravel .
	@docker-compose run composer require "squizlabs/php_codesniffer=*"

composer-install:
	@docker-compose run composer install

composer-update:
	@docker-compose run composer update

docker-start:
	docker-compose up -d

docker-stop:
	@docker-compose down -v

code-sniff:
	@echo "Running the code sniffer..."
	@docker-compose exec -T php ./vendor/bin/phpcs --standard=phpcs.xml

test: code-sniff
	@echo "Running the testing..."
	@docker-compose exec -T php ./vendor/bin/phpunit --colors=always --no-coverage