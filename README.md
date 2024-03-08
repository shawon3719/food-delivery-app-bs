## BS Test Food Delivery App
API for Food Delivery app

## Running with Docker

>Make sure you have `docker` and `docker-compose` installed in your machine

>The default password for MySQL is `password` and the username is `root`

## Update your .env

- Run `cp .env.example .env` command to copy example into real .env file, then edit it with DB credentials and other settings you want.

## Run application
To run the this project using Docker, ensure you have Docker and Docker Compose installed on Linux. For Windows and macOS, make sure you have Docker Desktop installed. Follow the instructions below:

Navigate to the project directory

```
cd /path/to/your/project_directory
```

Run below command to run application
```
docker-compose up -d
```
## List running docker container
```
docker ps
```

## Execute artisan command

Open a shell within the Docker container
- Run `docker exec -it bs-app bash`

Then bash will open and run the following commands

- Run `composer install`            # Install PHP dependencies
- Run `php artisan migrate`         # Run database migrations
- Run `php artisan storage:link`    # Run database migrations

### Or run one by one
```
docker exec -it [CONTAINER_NAME] php artisan [COMMAND]

e.g.
docker exec -it bs-app php artisan migrate
```

## Execute composer command
```
docker exec -it [CONTAINER_NAME] composer install

e.g.
docker exec -it bs-app composer install
```
and so on.

> For this app the container name `bs-app`

##### Access the application at `http://localhost:your_port`
Project is set up on port `8085`

##### PhpMyAdmin is available at  `http://localhost:your_port`
Access the database at port `7015`

## Application Developers

Develoved by : [Masudul Hasan Shawon](https://www.linkedin.com/in/masudul-hasan-shawon/)


## Application Requirements

- PHP >= 8.1
- MySQL >= 5.7
- Laravel >= 10
- BCMath PHP Extension
- Ctype PHP Extension
- Fileinfo PHP extension
- JSON PHP Extension
- Mbstring PHP Extension
- OpenSSL PHP Extension
- PDO PHP Extension
- Tokenizer PHP Extension
- XML PHP Extension
- exif PHP Extension


## Developed using Laravel 10

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT). | Chat App is a product of SmartWebSource. 

