#!/bin/bash
docker-compose exec api bash -c "php bin/console doctrine:migration:migrate first --env=test --no-interaction"

sleep 5s

docker-compose exec api bash -c "php bin/console doctrine:migration:migrate --env=test --no-interaction"

sleep 5s

docker-compose exec api bash -c "php vendor/bin/phpunit"