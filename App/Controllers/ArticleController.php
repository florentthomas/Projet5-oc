<?php

namespace App\Controllers;


class ArticleController extends Controller{

    public $articleManager;

    public function __construct(){

        $this->articleManager= $this->model("ArticleManager");
        $this->commentManager=$this->model("CommentManager");
    }

   
    public function index($params){

        $id=$params[2];

        $article=$this->articleManager->getArticle($id);
        $comments=$this->commentManager->getCommentsByArticle($id);

        

        foreach($comments as $comment){
            $commentsById[$comment->id]=$comment;    
            
        }
       
        foreach($comments as $k => $comment){
        
            if($comment->id_parent != 0){
                $commentsById[$comment->id_parent]->children[]=$comment;
                unset($comments[$k]);
            }
        }
        

        if($article){
            $this->view("Article",array("article" => $article,
                                        "comments" => $comments));
        }

        else{
            header('HTTP/1.0 404 Not Found');  
            $this->view("404"); 
        }

    }

}