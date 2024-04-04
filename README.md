# Decription
A small program built without using  dependencies to store a list of movies 

# Achitecture
Basic architecture principles

## System
The project contains a folder for system files, which is something that can be easily reused in other projects.

- `/src` - all main system components 
- `/vendor` - for storing composer files
- `/configs` - configuration files
- `/docker` - everything you need to run
- `public/public.php` - This is the entry point for the project where all the main components are pulled up and the processing of routs begins with the `App::run()` command

## Client
Almost everything in the folder is client code

The life cycle of a request is as follows:
- The system finds the routers in the `router.php`  
- We get to the `Controller` 
- If this is a `Controller` method for a **GET** request, then we usually get some data to be processed by the component, and immediately get to the view where the received data is generated in HTML using `Component` classes
- If this is a `Controller` method for a **POST** request, then we usually get some data from the form, and process it using the `Validator` classes. If the validation is successful, then we work with the database using the `Service` class and direct the user to another page. If it is unsuccessful, we return the user to the same page by displaying errors through the `ErrorComponent`.


# Working with project
We have two options, local and docker (preferred)

## Docker
To launch, you only need to have a docker, and docker compose

After cloning:
- `cd docker`
- `docker compose up -d`
- `docker-compose run --rm composer install`
- Go to: `localhost:8000/` 

Thats all!

## Localy

To launch, you at least need to have a php, composer, MySQL, PDO, pdo_mysql

After cloning:
- `composer install`
- Create database with name like MYSQL_DATABASE in `docker\env\mysql.env`
- You need to run the script for this database `docker\scripts\tables.sql`
- Change `configs/database.php` with your credentials
- `composer serve`

- Go to: `localhost:8000/`
