git pull origin master
composer update
php bin/console cache:clear --env=prod
chmod -R 777 var
