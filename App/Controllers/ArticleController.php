<?php

namespace App\Controllers;

use App\Views\View;
use App\Models\ArticleManager;

class ArticleController extends Controller{

    public $articleManager;

    public function __construct(){

        $this->articleManager= $this->model_manager("ArticleManager");
    }

   
    public function index($params){

        $id=$params[1];

        $article=$this->articleManager->getArticle($id);

        if($article){
            $this->view("Article",array("article" => $this->model("ArticleModel",$article)));
        }

        else{
            header('HTTP/1.0 404 Not Found');  
            $this->view("404"); 
        }

    }

}