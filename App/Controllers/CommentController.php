<?php

namespace App\Controllers;


class CommentController extends Controller{



    public function __construct(){

        $this->commentManager=$this->model("CommentManager");
        $this->userManager=$this->model("userManager");
    }


    public function index(){

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

    public function report_comment(){

        if($_SESSION["user"]->account_confirmed == 1){


            $comment= $this->commentManager->get_comment($_POST["comment_id"]);

            if( $comment != null){

                

                $users_report=unserialize($comment->users_report);

                $id_user=$_SESSION["user"]->id;




                

                if(!in_array($id_user,$users_report)){

                    array_push($users_report,$_SESSION["user"]->id);

                    $this->commentManager->report_comment($_POST["comment_id"],serialize($users_report));

                    $reponse=["attribute" =>"success", "message" => "Commentaire signalé"];

                }else{
                    $reponse=["attribute" =>"error", "message" => "Vous avez déjà signalé ce commentaire"];
                }
               


            }else{
                $reponse=["attribute" =>"error", "message" => "Le commentaire n'existe pas"];
            }

            
        }else{

            $reponse=["attribute" =>"error", "message" => "Impossible de signaler le commentaire"];
        }

        echo json_encode($reponse);
    }


    public function delete_comment($params){
    
       $id_comment=$params[1];

       $comment=$this->commentManager->get_comment($id_comment);

       if($comment == null){

            $reponse = ["attribute" => "error", "message" => "Le commentaire n'existe pas"];

       }

       else{

        
           if($comment->id_parent == 0){

                $comments_children=$this->commentManager->getCommentsChildren($id_comment);

                if($comments_children != null){

                    foreach($comments_children as $comment_children){

                        $comments_to_delete[]=$comment_children->id;

                    }
                        
                    $comments_to_delete[]=$id_comment;

                    $this->commentManager->delete_comments($comments_to_delete);
                }

                
               
           }

            else{

                $this->commentManager->delete_comments(Array($id_comment));

            }

           $reponse = ["attribute" => "success", "message" => "commentaire supprimé"];
       }

       echo json_encode($reponse);
    }


    public function approve_comment($params){
    
        $id_comment=$params[1];
 
        $comment=$this->commentManager->get_comment($id_comment);
 
        if($comment == null){
         $reponse = ["attribute" => "error", "message" => "Le commentaire n'existe pas"];
        }
 
        else{
            $array_void=serialize(Array());

            $this->commentManager->approve_comment($id_comment, $array_void);
            $reponse = ["attribute" => "success", "message" => "commentaire approuvé"];
        }
 
        echo json_encode($reponse);
     }


    public function add_comment_article(){

        if(isset($_SESSION['user'])){

            if(isset($_POST["comment"]) && !empty($_POST["comment"])){

                $comment=strip_tags($_POST["comment"]);
                $id_user=$_SESSION["user"]->id;
                $url_photo=$_SESSION["user"]->url_photo;
                $pseudo_user=$_SESSION["user"]->pseudo;
                $users_report=serialize(Array());
               
                $this->commentManager->add_comment($comment,$_POST["id_parent"],$id_user,$_POST["id_article"],$users_report);
    
                    $response=["attribute" => "success", "message" => "commentaire envoyé", "url_photo"=>$url_photo,"pseudo_user"=>$pseudo_user];
                
            }

            else{
                $response=["attribute"=>"error","message" => "Le champs commentaire est vide"];
            }
        }
        
        else{
            $response=["attribute"=>"error","message" => "commentaire non envoyé"];
        }
        
        

        echo json_encode($response);
    }

}