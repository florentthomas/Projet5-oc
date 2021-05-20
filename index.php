<?php

require ("vendor/autoload.php");

use App\Router\Router;





$router=new Router($_GET['url']);


$router->get("/","BlogController@index");
<<<<<<< HEAD
$router->get("/blog/:slug-:id","ArticleController@show");
=======
$router->get("/blog/:slug-:id","ArticleController@index");
>>>>>>> page_article

$router->run();


