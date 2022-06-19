<?php


use Core\Router;

Router::get('/auth/login',['controller'=>'Main','action'=>'login']);
Router::get('/auth/signup',['controller'=>'Main','action'=>'signup']);