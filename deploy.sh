#!/bin/bash

cd ~/www
git pull origin master
compose install
php8.0 artisan migrate
