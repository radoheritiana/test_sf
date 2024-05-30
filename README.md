# Test Symfony
## Technos
* Symfony 7
* PHP >= 8.2
* SQLite
## Requirements
* Composer
* PHP >= 8.2
* Symfony cli (optionnal)
* Node

## Installation
* Install all composer dependencies
```shell
composer install
```
* Install all node dependencies
```shell
npm install
```

## Database configuration
In this test application, we use SQLite database, follow the following steps to configure :
* Create new file .env.local to test locally and add the following code
```ini
# .env.local
DATABASE_URL="sqlite:///%kernel.project_dir%/var/data.db"
```
* Now, create the database and run all migrations
```shell
# If you have symfony cli installed
# Create database
symfony console doctrine:database:create
# Run migrations
symfony console doctrine:migrations:migrate

# Else
# Create database
php bin/console doctrine:database:create
# Run migrations
php bin/console doctrine:migrations:migrate
```

## Run the application
* Run symfony server
```shell
# If you have symfony cli installed
symfony server:start
# Or
symfony serve

# Else
php -S localhost:8000
```
* Run node server to build assets
```shell
npm run dev
```

## Now we can open the link localhost:8000 in the navigator

## Features
* Show list of all team and player
* Add new team or player
* Sell or buy player between two team