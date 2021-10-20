<?php

namespace App\Controllers;


class AdminController extends Controller{

    public function __construct(){
        $this->articleManager= $this->model("ArticleManager");
        $this->userManager= $this->model("UserManager");
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

    public function user(){
        $this->view("User_admin");
    }

    public function search_user(){


        if(isset($_GET["user"])){

            $user=trim($_GET["user"]);

            $result=$this->userManager->search($user);

            echo json_encode($result);

        }
        
    }


    public function get_user(){

        if(isset($_POST["id_user"])){

            $test="id de l'utilisateur: ".$_POST["id_user"];

            echo json_encode ($test);
        }
    }
}