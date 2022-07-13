<?php

namespace App\Controllers;


class ArticleController extends Controller{

    public $articleManager;

    public function __construct(){

        $this->articleManager= $this->model("ArticleManager");
        $this->commentManager=$this->model("CommentManager");
        $this->userManager=$this->model("UserManager");
    }

   
    public function index($params){

        $id=$params[2];

        $article=$this->articleManager->get_article_by_id($id);
        $comments=$this->commentManager->getCommentsByArticle($id);
        $users=[];



        foreach($comments as $comment){
            $commentsById[$comment->id]=$comment;
        
            $users_id[]=$comment->id_user;    
            
        }

        if(isset($users_id) && $users_id ==! null){

            $users_id=array_unique($users_id);
            foreach($users_id as $user){
                $users[]=$this->userManager->get_user("id",$user);
            }

        } 
       
        foreach($comments as $k => $comment){
        
            if($comment->id_parent != 0){
                $commentsById[$comment->id_parent]->children[]=$comment;
                unset($comments[$k]);
            }
        }
        

        if($article){   
            $this->view("Article",array("article" => $article,
                                        "comments" => $comments,
                                        "users" => $users));
        }

        

        else{
            header('HTTP/1.0 404 Not Found');  
            $this->view("404"); 
        }

    }

    

}