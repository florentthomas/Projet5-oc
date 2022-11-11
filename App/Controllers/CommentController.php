<?php

namespace App\Controllers;


class CommentController extends Controller{



    public function __construct(){

        $this->commentManager=$this->model("CommentManager");
        $this->userManager=$this->model("userManager");
        $this->articleManager=$this->model("articleManager");
    }


    public function index(){

        if(isset($_SESSION["user"])){
            
            $current_user=$this->userManager->get_user("id",$_SESSION["user"]->id);

            if($current_user->type_user === "admin" || $current_user->type_user === "super_admin"){

                $comments=$this->commentManager->get_comments_reported();
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


                $this->view("report_comment",array("comments_reported" => $comments, "users" => $users));


            }

            else{
                header("Location:".URL);
                exit();
            }

        }

        else{
            header("Location:".URL);
            exit();
        }

        

    }

    private function is_allowed(){

   
        $current_user=$this->userManager->get_user("id",$_SESSION["user"]->id);

        
        if($current_user->type_user !== "admin"  && $current_user->type_user !== "super_admin"){

            header("403 Forbidden", false , 403);
            $response=["attribute" => "error", "message" => "Vous n'êtes pas autorisé à faire cette action", "redirect" => URL];
            echo json_encode ($response);
            exit();

        }
        

    }

    public function report_comment(){

        if(isset($_SESSION["user"]) && $_SESSION["user"]->account_confirmed == 1 && isset($_POST["comment_id"])){


            $comment= $this->commentManager->get_comment($_POST["comment_id"]);

            if( $comment != null){

                

                $users_report=unserialize($comment->users_report);

                $id_user=$_SESSION["user"]->id;

                
           
                if(!in_array($id_user,$users_report)){

                    array_push($users_report,$id_user);

                    $this->commentManager->report_comment($_POST["comment_id"],serialize($users_report));

                    $response=["attribute" =>"success", "message" => "Commentaire signalé"];

                }else{
                    $response=["attribute" =>"error", "message" => "Vous avez déjà signalé ce commentaire"];
                }
               


            }else{
                $response=["attribute" =>"error", "message" => "Le commentaire n'existe pas"];
            }

            
        }else{

            $response=["attribute" =>"error", "message" => "Impossible de signaler le commentaire"];
        }

        echo json_encode($response);
    }


    private function delete_comment($id_comment){

        $comment=$this->commentManager->get_comment($id_comment);

       
            
        if($comment->id_parent == 0){   

            $comments_children=$this->commentManager->getCommentsChildren($id_comment);

            if($comments_children != null){

                foreach($comments_children as $comment_children){

                    $this->commentManager->delete_comment($comment_children->id);

                }
                    
            }    

        }

        
        $this->commentManager->delete_comment($id_comment);

        
        $response = ["attribute" => "success", "message" => "commentaire supprimé"];
        

        
        return $response;
       
    }


    public function delete_comment_reported(){

        $this->is_allowed();

        $response = ["attribute" => "error", "message" => "impossible de supprimer le commentaire"];

        if(isset($_POST["comment_id"])){

            $comment=$this->commentManager->get_comment($_POST["comment_id"]);

            if($comment != null){
             
                $response=$this->delete_comment($_POST["comment_id"]);
            }

        }
        
        echo json_encode($response);

    }





    public function delete_own_comment(){

        $response = ["attribute" => "error", "message" => "impossible de supprimer le commentaire"];

        if(isset($_SESSION["user"]) && isset($_POST["comment_id"])){

            $comment=$this->commentManager->get_comment($_POST["comment_id"]);

            if($comment != null && $comment->id_user == $_SESSION["user"]->id){

               $response=$this->delete_comment($_POST["comment_id"]);
 
            }
    
        }

        echo json_encode($response);
    }


    public function approve_comment(){

        $this->is_allowed();

        $response = ["attribute" => "error", "message" => "Action impossible"];

        if(isset($_POST["comment_id"])){

            $comment=$this->commentManager->get_comment($_POST["comment_id"]);
 
            if($comment == null){
             $response = ["attribute" => "error", "message" => "Le commentaire n'existe pas"];
            }
     
            else{
                $array_void=serialize(Array());
    
                $this->commentManager->approve_comment($_POST["comment_id"], $array_void);
                $response = ["attribute" => "success", "message" => "commentaire approuvé"];
            }
        }
 
       
 
        echo json_encode($response);
     }


    public function add_comment_article(){


        if(isset($_SESSION['user']) && $_SESSION["user"]->account_confirmed == 1){


            if(isset($_POST["comment"]) && !empty($_POST["comment"]) && isset($_POST["id_parent"]) && is_numeric($_POST["id_parent"]) && isset($_POST["id_article"]) && is_numeric($_POST["id_article"])){

                
                if($this->articleManager->get_article_by_id($_POST["id_article"])){

                    if($_POST["id_parent"] != 0 && $this->commentManager->get_comment($_POST["id_parent"]) == null){
                        $response=["attribute" => "error", "message" => "impossible d'envoyer le commentaire"];
                        echo json_encode ($response);
                        exit();
                    }

                    $comment=htmlspecialchars(trim($_POST["comment"])); 

                    $user=Array("id" => $_SESSION["user"]->id,
                                "photo" => URL_IMG_AVATARS.$_SESSION["user"]->photo,
                                "pseudo" => $_SESSION["user"]->pseudo);
                    
                    $users_report=serialize(Array());


                    $id_comment=$this->commentManager->add_comment($comment,$_POST["id_parent"],$user["id"],$_POST["id_article"],$users_report);

                    $comment=$this->commentManager->get_comment($id_comment);

                    $comment->date_comment= date("d/m/Y", strtotime($comment->date_comment));
                    

                    $response=["attribute" => "success","message" => "Commentaire ajouté", "comment" => $comment ,"user" => $user];

                }
                
                else{
                    $response=["attribute" => "error", "message" => "l'article n'existe pas"];
                }
            }

            else{
                $response=["attribute" => "error", "message" => "impossible d'envoyer le commentaire"];
            }
            
        }
        
        else{
            $response=["attribute" => "error", "message" => "impossible d'envoyer le commentaire"];
        }
        
        echo json_encode ($response);
    }

}