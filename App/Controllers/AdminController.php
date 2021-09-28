<?php

namespace App\Controllers;


class AdminController extends Controller{

    public function __construct(){
        $this->articleManager= $this->model("ArticleManager");
    }

    public function index(){

        if($_SESSION["user"]->type_user === "admin"){
            $this->view("Admin_blog");
        }

        else{
            header("Location:".URL);
        }

    }


    public function create_article(){

        $this->view("create_article");
    
    }


    public function edit_article(){

        $articles=$this->articleManager->get_all_articles();


        $this->view("list_article_edit", ["articles" => $articles]);
    }
}