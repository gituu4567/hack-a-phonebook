## Dependencies
* Php ^7.1
* Mysql 5.6 - [Installation](https://dev.mysql.com/doc/refman/5.6/en/installing.html)
* Laravel 5.7 - [Install Laravel](https://laravel.com/docs/5.7/installation)
* JWT-Auth - [tymondesigns/jwt-auth](https://github.com/tymondesigns/jwt-auth)
* Dingo API - [dingo/api](https://github.com/dingo/api)

## Steps for installing/upgrading to php 7.1
* `sudo add-apt-repository ppa:ondrej/php`
* `sudo apt-get update`
* `sudo apt-get install software-properties-common python-software-properties`
* `dpkg -l | grep php | tee packages.txt` : check packages installed with php and later install 7.1 variants of the same
* `sudo apt-get install php7.1 php7.1-common`
* `sudo apt-get install php7.1-curl php7.1-xml php7.1-zip php7.1-gd php7.1-mysql php7.1-mbstring`
* `sudo apt-get purge php7.0 php7.0-common` : optional

### Create MySql db and user
* Check .env file for mysql values being used
* Login to mysql, and then run
* `create database hackaphonebook;`
* GRANT ALL PRIVILEGES ON `hackaphonebook`.* TO 'hackaphonebook'@'localhost' IDENTIFIED BY 'password';
* Check you can login using the password: `mysql -uhackaphonebook hackaphonebook -p`

## Setup application - check dependencies above are installed first
* Clone respository
* `composer install`
* `php artisan migrate`
* `php artisan jwt:secret`
* `php artisan vendor:publish --provider="Tymon\JWTAuth\Providers\JWTAuthServiceProvider"`
* `php artisan serve`

## For security reasons and best practices .env file is not checked in. Check the following entries
* mysql username, password etc
* JWT_SECRET must be set, after you run php artisan jwt:secret above
* add `API_PREFIX=api`

## API Routes

### Auth routes: register and login both return a token that can be used
* `/api/auth/register`
* `/api/auth/login`

### Pass request param `token` received by login or register above into below routes.
* `POST`: `/api/contacts/create`
* `GET`: `/api/contacts/get`
* `GET`: `/api/contacts/get/{id}`
* `POST`: `/api/contacts/update/{id}`
* `DELETE`: `/api/contacts/delete/{id}`

### Postman
* import hackaphonebook-localhost.postman_collection.json into postman to test routes

### Test auth routes using curl

* curl -X POST localhost:8000/api/auth/register \
    -H "Accept: application/json" \
    -H "Content-type: application/json" \
    -d "{\"email\": \"test@email.com\", \"password\": \"password\" }"

* curl -X POST localhost:8000/api/auth/login \
    -H "Accept: application/json" \
    -H "Content-type: application/json" \
    -d "{\"email\": \"test@email.com\", \"password\": \"password\" }"


## Testing


