<?php

namespace App\Controllers;



abstract class Controller{

    public function view($file,$data=[]){

        $loader = new \Twig\Loader\FilesystemLoader(PATH_VIEWS_FOLDER);

        $twig = new \Twig\Environment($loader, [
            'cache' => false,
        ]);
            
        echo $twig->render($file.".twig", $data);
    }

    public function model($model,$data){

        $class="App\\Models\\".$model;
        return new $class($data);
    }

    public function model_manager($model_manager){
        $class="App\\Models\\".$model_manager;
        return new $class();
    }
}