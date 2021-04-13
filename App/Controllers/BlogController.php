<?php

namespace App\Controllers;

use App\Views\View;

class BlogController{

    public function index(){
        $view=new View;
        $view->generate_View("BlogHome",array("titre" => "titre d'un article"));
    }

    public function show(){
        echo "page de l'article";
    }
}