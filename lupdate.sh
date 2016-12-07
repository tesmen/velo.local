#!/bin/sh
git reset HEAD
git pull

php bin/console assets:install
php bin/console doc:sch:upd --force

php bin/console cache:clear --env=prod
php bin/console cache:clear --env=dev