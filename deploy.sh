#!/bin/bash

cd ~/www
git pull origin master
composer install
php8.0 artisan migrate
