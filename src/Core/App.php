<?php

namespace Core;
use Core\Database;

class App {
    public Router $router;
    public Request $request;
    public Response $response;
    public Database $db;
        /**
     * we will assign this later in \Core\Router::dispatch();
     * and make use of it for controller specific view in \Core\View::renderView();
     * 
     */
    // public ?Controller $controller = null; 


    public function __construct($config = []){
        $this->request = new Request();
        $this->response = new Response();
        $this->router = new Router($this->request,$this->response);
        $this->db = new Database($config['db']);
    }

    public function run(){
        try{
            echo $this->router->dispatch();
            exit;
        }catch(\Exception $e){
            ErrorHandler::handleException($e);
        }
    }
}