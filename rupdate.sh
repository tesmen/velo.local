#!/bin/sh
git reset HEAD
git pull

php5.6 bin/console assets:install
php5.6 bin/console doc:sch:upd --force

php5.6 bin/console cache:clear --env=prod
php5.6 bin/console cache:clear --env=dev