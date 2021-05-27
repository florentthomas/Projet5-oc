<?php

namespace App\Controllers;


class BlogController extends Controller{

    public function index(){

        $this->view("BlogHome",array("titre" => "titre d'un article"));
    }

    public function show(){
        echo "page de l'article";
    }
}