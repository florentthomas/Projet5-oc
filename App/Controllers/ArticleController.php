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

            $comments=$data["comments"];
            $users=$data["users"];
    
            
            $this->view("Article",array("article" => $article,
                                        "comments" => $comments,
                                        "users" => $users));

        }
        

        else{
            $this->view("404"); 
            header('HTTP/1.0 404 Not Found');  
            
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


        // récupère les 10 premiers commentaires sans les reponses aux commentaires
        $comments_to_show=$this->commentManager->getCommentsPagination($id_article, $comments_per_page,$offset);

        // récupère tous les commentaires de l'article
        $all_comments_article=$this->commentManager->getCommentsByArticle($id_article);

        
        

        $users=[];
        $users_id=[];
        $comments=[];

        if($comments_to_show != null && $all_comments_article != null){

            

            
            foreach($comments_to_show as $comment_to_show){

                foreach($all_comments_article as $comment){

                    if($comment->id_parent == $comment_to_show->id){

                        //stock tous les commentaires enfants des 10 premiers commentaires recupérés plus tôt

                        $children=$this->commentManager->getCommentsChildren($comment_to_show->id);

                        
                        $comment_to_show->children=$children;
                        
                    }

                    $users_id[]=$comment_to_show->id_user;

                }

                
                $comments[]=$comment_to_show;

            }

            if(isset($children) && $children != null){

                foreach($children as $child){

                    $users_id[]=$child->id_user;
                }

            }

            

            
            $users_id=array_unique($users_id);

            foreach($users_id as $user_id){

                $user=$this->userManager->get_user("id",$user_id);

                if($user != false){
                    $users[]=$user;
                }
                
            }


            if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' ) {

                if($users != null){
                    foreach($users as $user){
                        $user->photo=URL_IMG_AVATARS.$user->photo;
                    }

                }

                
                foreach($comments as $comment){

                    $date_format = date("d/m/Y", strtotime($comment->date_comment));
                    $comment->date_comment= date("d/m/Y", strtotime($comment->date_comment));

                }

                if(isset($_SESSION["user"]) && $_SESSION["user"]->account_confirmed == 1 ){
                    $account_confirmed= true;
                }
                else{
                    $account_confirmed= false;
                }

                $response=["comments" => $comments, "users" => $users, "account_confirmed" => $account_confirmed];

                echo json_encode($response);
            }

            else{
                return Array("users" => $users , "comments" => $comments);
            }
        }

        else{


            
            if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' ) {

                $response=[null];

                echo json_encode($response);
            }
        }
    }
    

}