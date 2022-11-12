<?php

namespace App\Controllers;


class BlogController extends Controller{

    public function __construct(){

        $this->userManager=$this->model("UserManager");
        $this->ArticleManager=$this->model("ArticleManager");
    }

    public function index(){

        $articles_count=count($this->ArticleManager->get_all_articles());

        $per_page=6;

        $pages=ceil($articles_count / $per_page);


        if(isset($_GET["page"])){

            if($_GET["page"] === "1"){
                header("Location:".URL);
                http_response_code(301);
                exit();
            }

            if(!filter_var($_GET["page"], FILTER_VALIDATE_INT)){
                throw new \Exception("numéro de page invalide");
            }

            $current_page= (int) $_GET["page"];

            if($current_page <= 0 || $current_page > $pages){
                throw new \Exception("numéro de page invalide");
            }
        }

        else{
            $current_page= 1;
        }

        $offset= $per_page *($current_page - 1);

    

        $articles= $this->ArticleManager->get_articles_pagination($per_page,$offset);

        


        foreach($articles as $article){
            $article->image_article=URL_IMG_ARTICLE.$article->image_article;
        }
    

        $this->view("BlogHome",array("articles" => $articles, "current_page" => $current_page, "pages_total" => $pages));
    }


    public function no_script(){
        $this->view("no_script");
    }


    
}