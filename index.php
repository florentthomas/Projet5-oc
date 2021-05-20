<?php

require ("vendor/autoload.php");

use App\Router\Router;





$router=new Router($_GET['url']);


$router->get("/","BlogController@index");

$router->get("/blog/:slug-:id","ArticleController@index");


$router->run();


