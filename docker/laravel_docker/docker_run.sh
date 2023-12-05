#!/bin/bash

echo "docker composer run"

## docker build
docker-compose up -d --build --force-recreate

## laravel install
docker-compose exec app composer create-project laravel/laravel --prefer-dist application

## npm install
docker-compose exec app bash -c "cd ./application && npm install"
