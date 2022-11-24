default:

lint:
	docker exec -it php-todos-web-1 sh -c "./vendor/bin/phpstan analyse"

fmt:
	docker exec -it php-todos-web-1 sh -c "./vendor/bin/phpcbf --standard=PSR12 --ignore=\"./vendor\" ./"

.PHONY: default lint fmt
