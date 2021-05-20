<?php

namespace App\Controllers;

use App\Views\View;
use App\Models\ArticleManager;

class ArticleController{


    public function index($params){

        $id=$params[1];

        $articleManager=new ArticleManager;

        $articles=$articleManager->getArticle($id);

    
        if($articles){

            $commentManager=new CommentManager;
            $comments=$commentManager->get_comments_by_article($id);

            $view=new View;
            $view->generate_View("Article",array("titre" => $article->get_title(),
                                                 "description" => substr($article->content(),0,150), 
                                                 "article" => $articles,
                                                 "comments" => $comments));
        }

        else{
            header('HTTP/1.0 404 Not Found');   
        }

    }

}