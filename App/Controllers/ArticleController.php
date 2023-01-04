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

        $id_article=$params[2];

        $article=$this->articleManager->get_article_by_id($id_article);

        if($article){

            $data=$this->getComments($id_article);
            $comments=null;

            if($data != null){
                $comments=$data["comments"];
                
            }

            
            
    
            
            $this->view("Article",array("article" => $article,
                                        "comments" => $comments));

        }
        

        else{
            http_response_code(404);
            $this->view("404"); 
        }

    }


    public function getComments($id_article=null){

        $current_page=1;

        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' ) {
               

               if(isset($_POST["id_article"]) && !empty($_POST["id_article"]) && isset($_POST["current_page"]) && !empty($_POST["current_page"]) && is_numeric($_POST["id_article"]) && is_numeric($_POST["current_page"])){
                    
                    
                    $id_article=$_POST["id_article"];
                    $current_page=$_POST["current_page"];

               }

               else{
                header("500 Internal Server Error", true, 500);
               }
        }


        $comments_per_page=10;

        $offset= $comments_per_page * ($current_page - 1);

        
        $comments=$this->commentManager->getCommentsPagination($id_article, $comments_per_page,$offset);
        

        foreach ($comments as $comment){

            $comment->user=$this->userManager->get_user("id",$comment->id_user);

            $children=$this->commentManager->getCommentsChildren($comment->id);

            foreach($children as $child){

                $child->user=$this->userManager->get_user("id",$child->id_user);
            }

            $comment->children=$children;

        }

        
        

        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' ) {


            foreach($comments as $index => $comment){

                $comment->date_comment= date("d/m/Y", strtotime($comment->date_comment));

                if($comment->user != false){
                    $comment->user->photo=URL_IMG_AVATARS.$comment->user->photo;
                }

                
                if(isset($comment->children) && $comment->children != null ){
                    
                    foreach($comment->children as $child){

                        $child->date_comment=date("d/m/Y", strtotime($child->date_comment));
                        $child->user->photo=URL_IMG_AVATARS.$child->user->photo;
                    }
                }

            }

            

            if(isset($_SESSION["user"]) && $_SESSION["user"]->account_confirmed == 1 ){
                $account_confirmed= true;
                $current_user=$_SESSION["user"]->id;
            }
            else{
                $account_confirmed= false;
                $current_user=false;
            }

            $response=["comments" => $comments, "account_confirmed" => $account_confirmed, "current_user" => $current_user];

            echo json_encode($response);
        }

        else{
            return Array("comments" => $comments);
        }
        

    }
    

}