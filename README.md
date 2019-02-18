## Dependencies
* Php ^7.1
* Mysql 5.6
* Laravel 5.7

## Steps for Laravel installation
* Install Laravel https://laravel.com/docs/5.7/installation

## Steps for upgrading to php 7.1 if not already
* sudo add-apt-repository ppa:ondrej/php
* sudo apt-get update
* sudo apt-get install software-properties-common python-software-properties
* dpkg -l | grep php | tee packages.txt
* sudo apt-get install php7.1 php7.1-common
* sudo apt-get install php7.1-curl php7.1-xml php7.1-zip php7.1-gd php7.1-mysql php7.1-mbstring
* sudo apt-get purge php7.0 php7.0-common

## Setup Mysql
* See mysql 5.6 docs

### Create MySql db and user
* Check .env file for mysql values being used.
* Login to mysql, and then run
* create database hackaphonebook;
* GRANT ALL PRIVILEGES ON `hackaphonebook`.* TO 'hackaphonebook'@'localhost' IDENTIFIED BY 'password';
* Check you can login using the password: `mysql -uhackaphonebook hackaphonebook -p`


## Setup application - check dependencies above are installed first
* Clone respository
* composer install
* php artisan migrate
* php artisan jwt:secret
* php artisan vendor:publish --provider="Tymon\JWTAuth\Providers\JWTAuthServiceProvider"
* php artisan serve

## For security reasons and best practices .env file is not checked in. Check the following
* mysql username, password etc
* JWT_SECRET must be set, after you run php artisan jwt:secret above
* add `API_PREFIX=api`

## Routes. Suggest using postman to test. Pass request param token for /api/contacts/ to works

* /api/auth/register
* /api/auth/login
* /api/contacts/create
* /api/contacts/get
* /api/contacts/get/{id}
* /api/contacts/update/{id}
* /api/contacts/delete/{id}

### Test auth routes using curl

* curl -X POST localhost:8000/api/auth/register \
    -H "Accept: application/json" \
    -H "Content-type: application/json" \
    -d "{\"email\": \"test@email.com\", \"password\": \"password\" }"

* curl -X POST localhost:8000/api/auth/login \
    -H "Accept: application/json" \
    -H "Content-type: application/json" \
    -d "{\"email\": \"test@email.com\", \"password\": \"password\" }"





