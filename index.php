<?php

require ("vendor/autoload.php");

$router=new Router($url);

$router->get("/","BlogController@index");
$router->get("/blog/:slug-:id","BlogController@show");


