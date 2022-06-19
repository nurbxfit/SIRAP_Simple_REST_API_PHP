<?php


use Core\Router;

/**
 * API ROutes
 * Here is where you can register API routes for your application.
 */

Router::get('/',['controller'=>'Main','action'=>'index']);
Router::get('/test',['controller'=>'Main','action'=>'test']);
