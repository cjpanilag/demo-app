<p style="font-size: 50px" align="center">Demo App</p>

## About

Simple Demo application for P.O.S web.

features:

- Make a sale
- Sales report `daily`, `weekly` or `montly`
- Download report to `excel` or `PDF`

## Stack 

- [Laravel](https://laravel.com/)
- [jQuery](https://jquery.com/)
- [Bootstrap](https://getbootstrap.com/)
- [MySQL](https://www.mysql.com/)

## Local Installation & Setup  

__*note: highly recommended to use Docker for this project*__

Requirements:

- [composer](https://getcomposer.org/)
- [PHP 8.1 and above](https://www.php.net/downloads.php)
- [MySQL 8.0](https://www.mysql.com/)

Setup

1. clone the repository
2. copy `env.example` to `.env` file
3. go to project root directory

    ```bash
    $ cd demo-app/
    ```

4. composer install

    ```bash
    $ composer install
    ```

5. artisan run

    ```bash
    $ php artisan migrate --seed
    ```

6. access `localhost:8080` to the browser

## Docker Setup `recommended`

Requirements: 

1. [Docker](https://www.docker.com/) 

Setup:

1. clone repository

2. copy `env.example` to `.env` file

3. go to project root directory

    ```bash
    $ cd demo-app/
    ```

4. run docker

    ```bash
    $ docker-compose --env-file docker/docker.env up --build -d
    ```

5. get inside docker bash

    list docker containers
    
    ```bash
    $ docker ps
    ```

    you will see all containers running. but we will focus on this container name: `demo-app-api`

    ```bash
    $ docker exec -it demo-app-api /bin/bash
    ```

    you are now inside the container shell. then run this command

    ```bash
    $ php artisan migrate --seed
    ```

    important to migrate inside the container not outside the container.

    thats it. now access `localhost:8081`


## Author

[Carl Jeffrie Panilag](https://github.com/cjpanilag)
