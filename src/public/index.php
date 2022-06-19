<?php

/**
 * using spl autoloader to load all class on their namespace
 */

spl_autoload_register(function($class){
    $root = dirname(__DIR__);
    $file = $root . '/' . str_replace('\\','/',$class) . '.php';
    if(is_readable($file)){
        require $file;
    }
});

// load all route's files inside App\Routes;
foreach (glob(dirname(__DIR__)."/App/Routes/*.php") as $filename) {
    if(is_readable($filename)){
       require $filename;
    }
}

use Core\App;
use Core\Router;
use Core\Request;
use Core\Response;
use Core\ErrorHandler;

// set_exception_handler(ErrorHandler::handleException);

$config = [
    'db' => [
        'host'=> 'mysqldb',
        'user'=> 'mysqluser',
        'password'=> 'mysqlpassword',
        'db_name'=> 'apidemo',
    ],
    'app_hostname' => 'localhost',
];

$app  = new App($config);

//API routes
// Router::get('/api',['controller'=>'Main','action'=>'index']);
// Router::get('/api/test',['controller'=>'Main','action'=>'test']);

$app->run();
?>