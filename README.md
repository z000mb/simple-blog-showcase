# simple-blog-showcase
#### Maciej Sobolak

Symfony simple blog application.

## Pre-requirements
You need `docker` and `docker compose v2` stack.\
Additionally, you need `make` package.\
I run the application in the Linux environment.

#### To run the application, I encourage you to use the `make` command that you will see below.
#### If you use an application address other than http://localhost:8000, you must set the `APP_URL` in `.env`
#### If you run `docker compose up` manually the first time, you need to initialize the database and optionally fill it with fixtures
```bash
docker compose exec php-fpm php bin/console doctrine:migrations:migrate -n
docker compose exec php-fpm php bin/console doctrine:fixtures:load -n
docker compose exec php-fpm php bin/console assets:install -n
```

## Default App URL
```
http://localhost:8000
```

## Default App API documentation - OpenAPI (Swagger)
```
http://localhost:8000/api/doc
```

# Makefile
### Manage docker compose stack
```bash
make start # running docker compose up -d --build and performs migrations / fixtures
make stop # running docker compose down
```

### Enter into `php-fpm` container
```bash
make sh
```

### Symfony shortcuts
```bash
make cc  # clear cache
```

### App create Post CLI
```bash
make create-post title="Post title" content="Post content" image="Post image base64"
```

### App create Post CLI Example
```bash
make create-post title="Post title" content="Lorem Ipsum is simply dummy text of the printing and typesetting industry." image="data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD//gAfQ29tcHJlc3NlZCBieSBqcGVnLXJlY29tcHJlc3P/2wCEAAQEBAQEBAQEBAQGBgUGBggHBwcHCAwJCQkJCQwTDA4MDA4MExEUEA8QFBEeFxUVFx4iHRsdIiolJSo0MjRERFwBBAQEBAQEBAQEBAYGBQYGCAcHBwcIDAkJCQkJDBMMDgwMDgwTERQQDxAUER4XFRUXHiIdGx0iKiUlKjQyNEREXP/CABEIACAAIAMBIgACEQEDEQH/xAAaAAEAAgMBAAAAAAAAAAAAAAAHBAgAAgUG/9oACAEBAAAAALjg8ewA2o8cyVY+eOe686sn/8QAFgEBAQEAAAAAAAAAAAAAAAAAAwQF/9oACAECEAAAANlJ1//EABcBAAMBAAAAAAAAAAAAAAAAAAMEBQb/2gAIAQMQAAAAwwKSn//EAC0QAAICAQMBBQcFAAAAAAAAAAECAwQFAAYREiExMlJxEyMzQUJRYRQWImJy/9oACAEBAAE/AN67zj27EtSoqyX5V5VT3IvmbWRyOdyiG/fnsyQs/SHPIi5P0jjs1QzOUxcolo3pomHyDcqfUHsOtkb2TcEbUrgWK/GvJA8Mg8y6myhv7ulyE9FryG0wFbp6yyL/ABAA1FL+66mR25kqcOPkCJLWjjZXaNQfqA7mH21S25suY3sBRsm1lDBJ79uT0Mvl+WsPasYXPVJvDJBZCSD8c9LDVupHi7NmrFCldHkYdxhWTn/PVNMfwOF0ktinbqT1UZrNZupawARmRuxlEMfIjB80h51Jm9m4a/bztWGwcpKJPcEEKHbxf10uIq5LJ4GSnkltW8hMZrcSr8E89ba3BhP1kT2ag6bKoRwr+yMv2RpACwX01nZ9x1zJSu1Ho1ufgwp0RN6sPH6k6Mue3NWxeLgoe1Smns42ij47Pu7d2tl7MXb0bXLhWTISrwSPDGvlXX//xAAfEQACAQQCAwAAAAAAAAAAAAABAhEAAwQTIUESJFH/2gAIAQIBAT8AQLhrbOsEkAu3yri2cxLgVCtxRIJEE1j+xx5CewacriITsO0iImeOq//EACIRAAICAQQBBQAAAAAAAAAAAAECAwQFABESIRMxUWFxgf/aAAgBAwEBPwCd5c3LYAtMiqSsMQB2Yj3PzqrLcwstYyTrJXkYq6q3JQR6/o1kgccefjbhvuhQdDVdJsvOkYrqKqkOX4FNmPbfZOv/2Q=="
```

### App create Post CLI Example directly from php-fpm container
```bash
php bin/console app:create-post "Post title" "Lorem Ipsum is simply dummy text of the printing and typesetting industry." "data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD//gAfQ29tcHJlc3NlZCBieSBqcGVnLXJlY29tcHJlc3P/2wCEAAQEBAQEBAQEBAQGBgUGBggHBwcHCAwJCQkJCQwTDA4MDA4MExEUEA8QFBEeFxUVFx4iHRsdIiolJSo0MjRERFwBBAQEBAQEBAQEBAYGBQYGCAcHBwcIDAkJCQkJDBMMDgwMDgwTERQQDxAUER4XFRUXHiIdGx0iKiUlKjQyNEREXP/CABEIACAAIAMBIgACEQEDEQH/xAAaAAEAAgMBAAAAAAAAAAAAAAAHBAgAAgUG/9oACAEBAAAAALjg8ewA2o8cyVY+eOe686sn/8QAFgEBAQEAAAAAAAAAAAAAAAAAAwQF/9oACAECEAAAANlJ1//EABcBAAMBAAAAAAAAAAAAAAAAAAMEBQb/2gAIAQMQAAAAwwKSn//EAC0QAAICAQMBBQcFAAAAAAAAAAECAwQFAAYREiExMlJxEyMzQUJRYRQWImJy/9oACAEBAAE/AN67zj27EtSoqyX5V5VT3IvmbWRyOdyiG/fnsyQs/SHPIi5P0jjs1QzOUxcolo3pomHyDcqfUHsOtkb2TcEbUrgWK/GvJA8Mg8y6myhv7ulyE9FryG0wFbp6yyL/ABAA1FL+66mR25kqcOPkCJLWjjZXaNQfqA7mH21S25suY3sBRsm1lDBJ79uT0Mvl+WsPasYXPVJvDJBZCSD8c9LDVupHi7NmrFCldHkYdxhWTn/PVNMfwOF0ktinbqT1UZrNZupawARmRuxlEMfIjB80h51Jm9m4a/bztWGwcpKJPcEEKHbxf10uIq5LJ4GSnkltW8hMZrcSr8E89ba3BhP1kT2ag6bKoRwr+yMv2RpACwX01nZ9x1zJSu1Ho1ufgwp0RN6sPH6k6Mue3NWxeLgoe1Smns42ij47Pu7d2tl7MXb0bXLhWTISrwSPDGvlXX//xAAfEQACAQQCAwAAAAAAAAAAAAABAhEAAwQTIUESJFH/2gAIAQIBAT8AQLhrbOsEkAu3yri2cxLgVCtxRIJEE1j+xx5CewacriITsO0iImeOq//EACIRAAICAQQBBQAAAAAAAAAAAAECAwQFABESIRMxUWFxgf/aAAgBAwEBPwCd5c3LYAtMiqSsMQB2Yj3PzqrLcwstYyTrJXkYq6q3JQR6/o1kgccefjbhvuhQdDVdJsvOkYrqKqkOX4FNmPbfZOv/2Q=="
```
### NOTE: base64 cannot be too long in CLI - because it cannot be pasted - due to lack of time, I did not find a solution at this point.