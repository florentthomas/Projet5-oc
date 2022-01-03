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

$router->post("/blog/:slug-:id/comment","ArticleController@add_comment_article");

$router->get("/inscription","InscriptionController@index");

$router->get("/confirm/:key","InscriptionController@confirm_account");

$router->get("/confirm_new_email/:key", "UserController@confirm_email");

$router->post("/inscription","InscriptionController@create_account");

$router->get("/admin_blog","AdminController@index");

$router->get("/admin_blog/creer_article","AdminController@create_article");

$router->get("/admin_blog/modifier_article","AdminController@edit_article");

$router->get("/admin_blog/utilisateur","AdminController@user");

$router->get("/admin_blog/recherche_utilisateur","AdminController@search_user");

$router->post("/admin_blog/recuperer_utilisateur","AdminController@get_user");

$router->post("/admin_blog/type_user","AdminController@change_type_user");

$router->post("/admin_blog/contact_user","AdminController@send_email_to_user");


$router->run();


