<?php

//PATH

define('PATH_VIEWS_FOLDER',str_replace('index.php','App/Views',$_SERVER['SCRIPT_FILENAME']));
define('PATH_ROOT',str_replace('index.php','',$_SERVER['SCRIPT_FILENAME']));
define('URL', str_replace('index.php', '', (isset($_SERVER['HTTPS']) ? 'https' : 'http').'://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']));

//Config_db

define('HOST','localhost');
define('USER','root');
define('PASSWORD','');
define('DB_NAME','projet_5_oc');
