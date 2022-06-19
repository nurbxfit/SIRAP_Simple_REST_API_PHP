<?php

namespace Core;

class Router{

    private string $controller_path = "App\Controllers\\";

    
    private Request $request;
    private Response $response;

    protected array $callback = [];
    protected static array $routes = [];

    public function __construct(Request $request, Response $response){
        $this->request = $request;
        $this->response = $response;
    }

    public static function get(string $route, array $callback = []) : void {
        // $this->routes['get'][$route] = $callback;
        self::add('get',$route,$callback);
    }

    public static function post(string $route, array $callback = []) : void {
        // $this->routes['post'][$route] = $callback;
        self::add('post',$route,$callback);
    }

    public static function put(string $route, array $callback = []) : void {
        // $this->routes['put'][$route] = $callback;
        self::add('put',$route,$callback);
    }

    public static function patch(string $route, array $callback = []) : void {
        // $this->routes['patch'][$route] = $callback;
        self::add('patch',$route,$callback);
    }

    public static function delete(string $route, array $callback = []) : void {
        // $this->routes['delete'][$route] = $callback;
        self::add('delete',$route,$callback);
    }

    public static function add(string $method, string $route, array $callback) : void {
        // convert route to reqular expression: escape foward slashes 
        $route = preg_replace('/\//','\\/',$route);

        //remove \{ and \} from {controllerName} add to regex
        $route = preg_replace('/\{([a-z]+)\}/','(?P<\1>[a-z-]+)',$route);

        //convert {id:\d+} to number 
        $route = preg_replace('/\{([a-z]+):([^\}]+)\}/','(?P<\1>\2)',$route);

        $route = '/^' . $route . '\/?$/i'; //match (with slash) `/something/` or `/something` (without slash)
        // echo 'Route:=> ' . $route;
        self::$routes[$method][$route] = $callback;
    }

    /**
     * Dispatcher are use to run our controller.
     */
    public function dispatch(): void {
        
        //check if current request path registered in routes
        if($this->match()){
            $controller_name = $this->studlyCase($this->callback['controller']);
            $controller_path = $this->controller_path . $controller_name;
            /**
             * TODO: check if controller class exist and is callable 
             * if callable, then we call the controller,
             */
            // $this->response->json([
            //     "message"=>"Matched",
            //     "name" => $controller_name,
            //     "path" => $controller_path
            // ]);
            if(class_exists($controller_path)){
                //if exist we check if callable
                $controller_method = $this->camelCase($this->callback['action']);
                $controller_object = new $controller_path();

                if(is_callable([$controller_object,$controller_method])){
                    //if callable, then execute the controller, by setting App main controller to the matched controller.
                    // becuase this is an API, so we dont't have view, so we not use App->controller for controller specific view.
                    // \Core\App::$app->controller = $controller_object;
                    // \Core\App::$app->controller->$controller_method($this->request,$this->response);
                    $controller_object->$controller_method($this->request,$this->response);
                }else {
                    $this->response->statusCode(404);
                    throw new exceptions\NotFoundException("Not Found");
                }

            }else {
                $this->response->statusCode(404);
                throw new exceptions\NotFoundException("Not Found");
            }
            
            
        }
        else {
            $this->response->statusCode(404);
            throw new exceptions\NotFoundException("Not Found");
        }
    }

    /**
     * Match will find the controller of the routes currently at.
     * check if current request path registered in routes
     */
    public function match() : bool {
        $method = $this->request->method();
        $path = $this->request->path(); // our current request path eg: /cat/
        if(isset(self::$routes[$method])){
            $routes = self::$routes[$method]; //current route based on method
            foreach($routes as $route => $callback){
                // print "<br> path: $path <br>";
                        /**
                 * Loop thru our stored routes, check if it match current path
                 * if match then we take the controller associated with the route path.
                 */
                if(preg_match($route,$path,$matches)){
                    foreach($matches as $key=>$match){
                        if(is_string($key)){
                            //take callback
                            $callback[$key] = $match;
                        }
                    }
                    //set current global callback
                    $this->callback = $callback;
                    return true;
                }
            }
        }
        return false;
    }


    //Convert string to studly_case
    public function studlyCase(string $str): string{
        return str_replace(' ', '', ucwords(str_replace(['-', '_'], ' ', $str)));
    }

    //convert string to camelCase
    public function camelCase(string $str) : string{
        return lcfirst($this->studlyCase($str));
    }


}