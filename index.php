<?php

session_start();

require ("vendor/autoload.php");
require ("App/config/config.php");

use App\Router\Router;


$router=new Router($_GET['url']);


$router->get("/","BlogController@index");

$router->get("/connection","BlogController@connection");

$router->post("/connection","BlogController@connection");

$router->get("/disconnect","BlogController@disconnect");

$router->get("/blog/:slug-:id","ArticleController@index");

$router->get("/inscription","InscriptionController@index");

$router->get("/confirm/:key","InscriptionController@confirm_account");

$router->post("/inscription","InscriptionController@check");


$router->run();


