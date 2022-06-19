<?php

namespace App\Controllers;

use Core\Controller;
use Core\Request;
use Core\Response;

use App\Models\TestModel;

class Main extends Controller{
    public function __construct(){}

    /**
     * This Before method get called before other routes method get called
     */
    // public function before(){
        // return true;
    // }

    /**
     * This after method get calle after other routes method get called
     */
    // public function after(){
         // echo "something";
    // }

    /**
     * All methods, declared as protected to trigger middleware calling,
     * refer: Core\Router::distpatch
     */
    protected function index(Request $request, Response $response){
        return $response->json([
            "From" => "Main Controller",
            "Using" => "Index Method",
            "Message" => "Hello World, Its working!"
        ]);
        // throw new \Exception('testing');
        
    }


    protected function test(Request $request, Response $response){
        // return $response->json([
        //     "message" => "Testing REST API",
        // ]);
        $model = new TestModel();
        $model->validate();
    }


    protected function login(Request $request, Response $response){
        return $response->json([
            "message" => "Testing REST API auth login",
        ]);
    }
    
    protected function signup(Request $request, Response $response){
        return $response->json([
            "message" => "Testing REST API auth signup",
        ]);
    }
}