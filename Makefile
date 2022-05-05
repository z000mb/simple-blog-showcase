start:
	docker compose up -d --build
	docker compose exec php-fpm php bin/console doctrine:migrations:migrate -n
	docker compose exec php-fpm php bin/console doctrine:fixtures:load -n
	docker compose exec php-fpm php bin/console assets:install -n

stop:
	docker compose down

sh:
	docker compose exec php-fpm sh

cc:
	docker compose exec php-fpm php bin/console c:c

create-post:
ifndef title
	@echo "\"title\" is not defined"
	exit 1
endif
ifndef content
	@echo "\"content\" is not defined"
	exit 1
endif
ifndef image
	@echo "\"image\" is not defined"
	exit 1
endif
	docker compose exec php-fpm php bin/console app:create-post "$(title)" "$(content)" "$(image)"