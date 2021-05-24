<?php

namespace App\Controllers;

use App\Views\View;
use App\Models\ArticleManager;

class ArticleController extends Controller{

   
    public function index($params){

        $id=$params[1];

        $articleManager=$this->model("ArticleManager");

        $article=$articleManager->getArticle($id);
    
        if($article){

             
            $this->view("Article",array("article" => $article));
        }

        else{
            header('HTTP/1.0 404 Not Found');   
        }

    }

}