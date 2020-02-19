<?php
include_once 'route/Router.php';

$router= new Router;

$router->get("/[home]",function(){
    //load the controller

    echo "hello world";
});

$router->run();