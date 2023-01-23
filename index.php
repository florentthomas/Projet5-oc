<?php

session_start();

require ("vendor/autoload.php");
require ("App/config/config.php");

use App\Router\Router;


$router=new Router($_GET['url']);


if(!isset($_GET["url"])){
    
    header("Location:".URL);
}

$router->get("/","BlogController@index");

//-------no_script-----------//

$router->get("/no_script","BlogController@no_script");

//------------------------//

//-----------connection---------------//

$router->get("/login","LoginController@index");
$router->get("/disconnect","LoginController@disconnect");
$router->post("/connection","LoginController@connection");

//----------------end--------------//


//------------setting_user-----------//

$router->get("/setting","UserController@index");

$router->post("/setting/change_pseudo", "UserController@pseudo");

$router->post("/setting/change_email", "UserController@email");

$router->post("/setting/change_password", "UserController@password");
 
$router->get("/setting/delete", "UserController@delete_account");

$router->get("/confirm_delete_account/:key", "UserController@confirm_delete_account");

$router->post("setting/change_photo","UserController@picture_account");

$router->get("password_forgot", "UserController@password_forgot");

$router->get("reset_password/:key", "UserController@reset_password");

$router->post("reset_password", "UserController@reset_password_apply");

$router->post("password_forgot", "UserController@password_forgot");

//--------------end----------------//



//-----------page_article---------------//

$router->get("/blog/:slug-:id","ArticleController@index");

$router->post("/blog/:slug-:id/comment","CommentController@add_comment_article");

$router->post("/blog/report_comment", "CommentController@report_comment");

$router->post("/admin_blog/delete_comment", "CommentController@delete_comment_reported");

$router->post("/admin_blog/approve_comment", "CommentController@approve_comment");

$router->post("/blog/get_comments", "ArticleController@getComments" );

$router->post("/blog/delete_comment","CommentController@delete_own_comment");

//---------------end-----------------//


//-------search_movie-----------//

$router->get("/rechercher","TMDB_api@search");  
$router->get("/rechercher/movie/:id","TMDB_api@get_movie");
$router->get("/rechercher/person/:id","TMDB_api@get_person");

//----------end----------------//



//-------------inscription--------------//

$router->get("/inscription","InscriptionController@index");

$router->get("/confirm/:key","InscriptionController@confirm_account");

$router->get("/confirm_new_email/:key", "UserController@confirm_email");

$router->post("/inscription","InscriptionController@create_account");

//----------------end--------------------/



//-----------create_article----------------//

$router->get("/admin_blog/creer_article","Create_articleController@index");

//-------------end----------------//



//--------insert_image_summernote---------//

$router->post("/summernote/add_image_summernote","SummernoteController@upload_image");

//-------------end----------------//



//-------------Admin_users---------------//

$router->get("/admin_blog/utilisateur","Admin_usersController@index");

$router->get("/admin_blog/recherche_utilisateur","Admin_usersController@search_user");

$router->post("/admin_blog/type_user","Admin_usersController@change_type_user");

$router->post("/admin_blog/contact_user","Admin_usersController@send_email_to_user");

$router->post("/admin_blog/delete_user","Admin_usersController@delete_user");

//-----------------end--------------------//


//------------edit_article---------------//

$router->get("/admin_blog/edit/:id","Edit_articleController@panel_edit_article");

$router->get("/admin_blog/modifier_article","Edit_articleController@index");

$router->post("admin_blog/edit/change_title","Edit_articleController@change_title");

$router->post("admin_blog/edit/change_slug","Edit_articleController@change_slug");

$router->post("admin_blog/edit/change_photo","Edit_articleController@change_photo");

$router->post("admin_blog/edit/change_description","Edit_articleController@change_description");

$router->post("admin_blog/edit/change_content","Edit_articleController@change_content");

$router->post("admin_blog/edit/delete_article","Edit_articleController@delete_article");


//-----------end-------------------//


//----------create_article-----------//

$router->post("/admin_blog/create_article","Create_articleController@create_article");

//----------end--------------//


//-----comments_reported----//

$router->get("admin_blog/commentaires_signales","CommentController@index");

//-----end------//


$router->run();
