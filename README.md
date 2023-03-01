## Inosoft Vehicles REST API

Vehicles REST API.


## Features

- Login / Logout
- List, create and detail Orders
- User profile
- List and detail Vehicles
- Swagger API Documentation (`/api/{VERSION}/documentation`)


## Installation Guide

- Clone repo with `git clone https://github.com/ramdani15/inosoft-vehicles-rest-api.git`
- Run `composer install`
- Copy `env.example` to `.env` and set it with your own credentials
- For testing copy `env.example` to `.env.testing` and set it with your own credentials
- Run `php artisan migrate:refresh --seed`
- Run `php artisan key:generate`
- Run testing `php artisan test`
- Run `php artisan serve`
- Open [http://localhost:8000](http://localhost:8000)


## Installation Guide (Docker Compose)

- Clone repo with `git clone https://github.com/ramdani15/inosoft-vehicles-rest-api.git`
- Copy `env.example` to `.env` and set it with your own credentials
- For testing copy `env.example` to `.env.testing` and set it with your own credentials
- Copy `/docker/env.example` to `/docker/.env` and set it with your own credentials
- Run `docker compose up -d --build`
- Run `docker compose exec app composer install`
- Run `docker compose exec app php artisan migrate:refresh --seed`
- Run `docker compose exec app php artisan key:generate`
- Run testing `docker compose exec app php artisan test`
- On `.env` set `DB_CONNECTION=mongodb`, `DB_HOST=db-inosoft` and `DB_PORT=27017`
- Open [http://localhost:8080](http://localhost:8080)


### Notes
- User testing `super@inosoft.com` with password `password123`
- Code style fixer with [Laravel Pint](https://github.com/laravel/pint) RUN : `sh pint.sh` or `docker compose exec app sh pint.sh` for Docker.
