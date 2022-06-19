# SIRAP (SIMPle REST API PHP)
A simple example of PHP REST API framework, built from scratch using vanilla PHP.

# RUN using docker
1. git clone the repo
2. cd into project folder
3. use docker-compose
    ```
    jun@b:~$ docker-compose up --build
    ```
    - you might get error about mysql not connect, just wait until mysql container up and running and refresh the page.
4. stop the container
    ```
    jun@b:~$ docker-compose down
    ```
# File structure
## Core
- the core directory contains the core framework code.

## App
- contains our app code, 
- we define the routes in the `App\Routes` folder and all files in this folder will be loaded.
- we define our models in `App\Models` extending the `Core\Model` class.
- we define our controllers in `App\Controllers` extending the `Core\Controllers` class.

## Public
- this is the main entry point of our application. request from `nginx` get redirected to `public/index.php`.

# Todo
this is just a simple example, I will update new things if I have time and ideas to do it.

Things to add:
- Sessions, and authentication example, using JWT
- Token expired and refresh token example
- using external environment-variable file.
- file upload example.