#!/bin/bash
./create_env.sh

docker-compose up --build -d
docker exec -ti php-fpm sh -c "composer install"
docker exec -ti php-fpm sh -c "mysql php_task < /php_task/docker/containers/php-fpm/script/sql/php_task.sql"
docker exec -ti php-fpm sh -c "php bin/console ParseCurrencies"
docker-compose stop