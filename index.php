<?php

require ("vendor/autoload.php");

use App\Router\Router;

$router=new Router($_GET['url']);


$router->get("/","BlogController@index");
$router->get("/blog/:slug-:id","BlogController@show");

$router->run();


