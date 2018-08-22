# Auction

This is a simple web application and API for products tender. It is built using  [Laravel](https://laravel.com/)

> Notice: This is for learning purpose, this project is not production ready.

- It web based
- REST API

It is built using laravel. Check out client android application **[Here](https://github.com/muhozi/Build-a-react-native-auction-android-app)**

## Requirements

- PHP, Composer

- MySQL database


## Set up the application 🛠

### Clone the repo

`git clone git@github.com:muhozi/auction-application.git`

### Install the dependencies

This project uses laravel (php framework) and you need to have a php package manager installed which is [Composer](https://getcomposer.org/)

`cd auction-backend`

`composer install`

### Set up project configurations

#### Create configuration file (.env)

Copy the contents of `.env.example` by running the following:

`cp .env.examle .env`

#### Generate application key

Run the following command to generate the application key(for encryption and hashing)

`php artisan key:generate`

#### Set up Database

Create database and replace DB connnection details section in `.env` 

```sh
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_name
DB_USERNAME=db_username
DB_PASSWORD=db_password
```

#### Run migrations

Run migration by running the following command:

`php artisan migrate`

#### Install passort(used for JWT)

Run the following command to set up for requirements to use passport(Laravel JWT authentication package). This will generate encryption keys and OAuth clients(Personal and Password grant clients)

`php artisan passport:install`

## Run the application 🚀

Run the application using the following command:

`php artisan serve`

## Authors

[Emery Muhozi](https://twitter.com/EmeryMuhozi)

## Licence

[MIT License](http://opensource.org/licenses/mit-license.html).
