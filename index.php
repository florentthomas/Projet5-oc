<?php

session_start();

require ("vendor/autoload.php");
require ("App/config/config.php");

use App\Router\Router;


$router=new Router($_GET['url']);


$router->get("/","BlogController@index");

$router->get("/connection","BlogController@connection");

$router->get("/setting","UserController@index");

$router->post("/setting/change_pseudo", "UserController@pseudo");

$router->post("/setting/change_email", "UserController@email");

$router->post("/setting/change_password", "UserController@password");
 
$router->get("/setting/delete/:key", "UserController@delete_account");

$router->get("/confirm_delete_account/:key", "UserController@confirm_delete_account");

$router->post("setting/change_photo","UserController@picture_account");

$router->get("password_forgot", "UserController@password_forgot");

$router->get("reset_password/:key", "UserController@reset_password");

$router->post("reset_password", "UserController@reset_password_apply");

$router->post("password_forgot", "UserController@password_forgot");

$router->post("/connection","BlogController@connection");

$router->get("/disconnect","BlogController@disconnect");

$router->get("/blog/:slug-:id","ArticleController@index");

$router->get("/inscription","InscriptionController@index");

$router->get("/confirm/:key","InscriptionController@confirm_account");

$router->get("/confirm_new_email/:key", "UserController@confirm_email");

$router->post("/inscription","InscriptionController@check");


$router->run();


