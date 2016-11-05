#!/bin/sh
git pull

php bin/console assets:install

php bin/console cache:clear --env=prod
php bin/console cache:clear --env=dev