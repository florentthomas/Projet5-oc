<?php

namespace App\Controllers;

use App\Tools\Tools;


class Create_articleController extends Controller{

    public function __construct(){
        $this->articleManager= $this->model("ArticleManager");
    }


    public function index(){

        $this->view("create_article");
    
    }


}