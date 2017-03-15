#!/usr/bin/env bash

git pull origin master
composer update
php bin/console doctrine:schema:update --force --dump-sql
php bin/console cache:clear --env=prod
chmod -R 777 var