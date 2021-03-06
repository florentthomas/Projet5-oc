<?php

session_start();

require ("vendor/autoload.php");
require ("App/config/config.php");

use App\Router\Router;


$router=new Router($_GET['url']);


$router->get("/","BlogController@index");

//-----------connection---------------//

$router->get("/connection","BlogController@connection");
$router->get("/disconnect","BlogController@disconnect");
$router->post("/connection","BlogController@connection");

//----------------end--------------//


//------------setting_user-----------//

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

//--------------end----------------//



//-----------page_article---------------//

$router->get("/blog/:slug-:id","ArticleController@index");

$router->post("/blog/:slug-:id/comment","ArticleController@add_comment_article");

//---------------end-----------------//



//-------------inscription--------------//

$router->get("/inscription","InscriptionController@index");

$router->get("/confirm/:key","InscriptionController@confirm_account");

$router->get("/confirm_new_email/:key", "UserController@confirm_email");

$router->post("/inscription","InscriptionController@create_account");

//----------------end--------------------/



//-----------create_article----------------//

$router->get("/admin_blog/creer_article","Create_articleController@index");

//-------------end----------------//



//-------------Admin_users---------------//

$router->get("/admin_blog/utilisateur","Admin_usersController@index");

$router->get("/admin_blog/recherche_utilisateur","Admin_usersController@search_user");

$router->post("/admin_blog/recuperer_utilisateur","Admin_usersController@get_user");

$router->post("/admin_blog/type_user","Admin_usersController@change_type_user");

$router->post("/admin_blog/contact_user","Admin_usersController@send_email_to_user");

$router->post("/admin_blog/delete_user","Admin_usersController@delete_user");

//-----------------end--------------------//


//------------edit_article---------------//

$router->get("/admin_blog/edit/:id","Edit_articleController@panel_edit_article");

$router->get("/admin_blog/modifier_article","Edit_articleController@index");

$router->post("admin_blog/edit/:id/change_title","Edit_articleController@change_title");

$router->post("admin_blog/edit/:id/change_slug","Edit_articleController@change_slug");

$router->post("admin_blog/edit/:id/change_photo","Edit_articleController@change_photo");

$router->post("admin_blog/edit/:id/change_description","Edit_articleController@change_description");

$router->post("admin_blog/edit/:id/change_content","Edit_articleController@change_content");

//-----------end-------------------//



$router->run();


