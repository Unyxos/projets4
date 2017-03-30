#!/usr/bin/env bash

php bin/console doctrine:schema:update --force --dump-sql
php bin/console cache:clear
chmod -R 777 var
