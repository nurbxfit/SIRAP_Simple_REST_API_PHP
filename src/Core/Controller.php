<?php

namespace Core;
/**
 * This is our base controller
 * Our controller in App\ will extends this controller
 * Controller get called inside Router.php->dispatch();
 */
abstract class Controller {
    public string $action;

    protected array $middlewares = [];
    /*
     *
     * This is a magic method, this method will get call automatically IF
     * - there is a method get called in this class but, there is no matching method names or
     * - there is a method get called from outside of the class, but the method is private.
     * 
     * We use this method to call a middleware, by writing our controller method as protected.
     * Then if we try to call the method from our Router, a middleware will be triggered. 
     */
    public function __call($methodName,$args){

        if(method_exists($this,$methodName)){
            //run $this->before() middleware, if return true, we continue, alse we not call our method
            if($this->before() === true){

                // run middleware registered to the controller
                foreach($this->middlewares as $middleware){
                    $middleware->execute($methodName);
                }
                // after finish calling the middleware, we can now call our controller->method()
                call_user_func_array([$this,$methodName],$args);

                //run $this->after middleware
                $this->after(); //return nothing
            }
        }
    }

    /**
     * This function will be call before a controller->method() get call
     */
    public function before(){
        return true;
    }

    /**
     * This function will be call after a controller->method() get called
     */
    public function after(){
    }

    /**
     * TODO create middleware in Core to use as Type here.
     */
    public function addMiddleware(Middleware $middleware){
        $this->middlewares[] = $middleware; 
    }
}