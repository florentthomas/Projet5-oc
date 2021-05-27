<?php

namespace App\Controllers;



abstract class Controller{

    public function view($file,$data=[]){

        $loader = new \Twig\Loader\FilesystemLoader(PATH_VIEWS_FOLDER);

        

        $twig = new \Twig\Environment($loader, [
            'cache' => false,
        ]);

        $twig->addGlobal("URL",URL);
            
        echo $twig->render($file.".twig", $data);
    }

    public function model($model){

        $class="App\\Models\\".$model;
        return new $class();
    }

}