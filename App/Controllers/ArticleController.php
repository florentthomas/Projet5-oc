<?php

namespace App\Controllers;

use App\Views\View;
use App\Models\ArticleManager;

class ArticleController{



    public function index($params){
        $id=$params[1];

        $articleManager=new ArticleManager;

        $articles=$articleManager->getArticle($id);

        if($articles->exists()){
            $view=new View;
            $view->generate_View("Article",array("titre" => $article->title()));
        }

        else{
            header('HTTP/1.0 404 Not Found');   
        }

    }

}