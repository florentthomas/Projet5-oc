<?php

//PATH

define('PATH_VIEWS_FOLDER',str_replace('index.php','App/Views',$_SERVER['SCRIPT_FILENAME']));
define('PATH_ROOT',str_replace('index.php','',$_SERVER['SCRIPT_FILENAME']));
define('URL', str_replace('index.php', '', (isset($_SERVER['HTTPS']) ? 'https' : 'http').'://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']));
define('PATH_IMG_ARTICLE', str_replace('index.php','',$_SERVER['SCRIPT_FILENAME'].'Public/images/articles'));
define('PATH_IMG_AVATARS', str_replace('index.php','',$_SERVER['SCRIPT_FILENAME'].'Public/images/avatars'));
define('URL_IMG_ARTICLE', URL.'Public/images/articles/');
define('URL_IMG_AVATARS', URL.'Public/images/avatars/');
define('URL_IMG', URL.'Public/images/');

//Email

// define('EMAIL', 'cine-film@outlook.fr');
// define('EMAIL_PASSWORD', 'Tff_dke#85%fdfs,;(du');

define('EMAIL', 'blog-cinema@florent-thomas.com');
define('EMAIL_PASSWORD', '_9zjZd@5HP*@E3!eK%$');




//key api

define('KEY_TMDB_API', '70c27cbd777e852dea8ad394a6841c9b');

//Config_db

define('HOST','localhost');
define('USER','root');
define('PASSWORD','');
define('DB_NAME','projet_5_oc');
