<?php

namespace App\Controllers;

use App\Views\View;
use App\Models\ArticleManager;

class ArticleController{



    public function index(){


        $articleManager=new ArticleManager;

        $articles=$articleManager->getArticle();

        $view=new View;
        $view->generate_View("Article",array("titre" => $article->title()));
    }

}