<?php

namespace App\Controllers;



abstract class Controller{

    public function view($file,$data=[]){

        $loader = new \Twig\Loader\FilesystemLoader(PATH_VIEWS_FOLDER);

        

        $twig = new \Twig\Environment($loader, [
            'cache' => false,
            'debug' => true,
        ]);

        $twig->addExtension(new \Twig\Extension\DebugExtension());
        $twig->addGlobal("URL",URL);
        $twig->addGlobal("session", $_SESSION);
        $twig->addGlobal("URL_IMG_ARTICLE", URL_IMG_ARTICLE);
        $twig->addGlobal("URL_IMG_AVATARS", URL_IMG_AVATARS);
            
        echo $twig->render($file.".twig", $data);
    }

    public function model($model){

        $class="App\\Models\\".$model;
        return new $class();
    }

}