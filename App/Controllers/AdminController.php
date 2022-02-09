<?php

namespace App\Controllers;

use App\Tools\Tools;


class AdminController extends Controller{

    public function __construct(){
        $this->articleManager= $this->model("ArticleManager");
        $this->userManager= $this->model("UserManager");
    }

    public function index(){

        if($_SESSION["user"]->type_user === "admin"){
            $this->view("Admin_blog");
        }

        else{
            header("Location:".URL);
        }

    }


    public function create_article(){

        $this->view("create_article");
    
    }


    public function edit_article(){

        $articles=$this->articleManager->get_all_articles();


        $this->view("list_article_edit", ["articles" => $articles]);
    }

    public function user(){
        $this->view("User_admin");
    }

    public function search_user(){


        if(isset($_GET["user"])){

            $user=trim($_GET["user"]);

            $result=$this->userManager->search($user);

            echo json_encode($result);

        }
        
    }


    public function get_user(){

        if(isset($_POST["id_user"])){

            $test="id de l'utilisateur: ".$_POST["id_user"];

            echo json_encode ($test);
        }
    }

    public function change_type_user(){

        if(isset($_POST["type_user"]) && isset($_POST["id_user"])){

            $type_user=$_POST["type_user"];

            $user=$this->userManager->get_user("id",$_POST['id_user']);

        
            if($type_user == "user" || $type_user == "editor" || $type_user="admin"){

                if($user !== false){

                    $request_update_user=$this->userManager->update_user("type_user",$type_user,$_POST["id_user"]);
                    
                    if($request_update_user){

                        $response=["attribute" => "success", "message" => "Changement effectué"];
                    }

                    else{
                        $response=["attribute" => "error", "message" => "Une erreur est survenue lors de l'execution de la requête"];
                    }

                    
                }

                else{
                    $response=["attribute"=>"error","message" => "L'utilisateur n'existe pas"];
                }
            }

            else{
                $response=["attribute"=> "error", "message" => "Type utilisateur non conforme"];
            }

        }

        else{
            $response=["attribute"=> "error", "message" => "Erreur dans le traitement des données"];
        }
        

        echo json_encode($response);
    }


    public function send_email_to_user(){

        if(isset($_POST["message"]) && !empty($_POST["message"]) && isset($_POST["id_user"]) && isset($_POST["subject"]) && !empty($_POST["subject"])){

            $user=$this->userManager->get_user("id",$_POST['id_user']);
            
            if($user != false){

                $email_user=$user->email;

                if(Tools::sendEmail($email_user,$_POST["subject"],$_POST["message"])){
                    $response=["attribute" => "success" , "message" => "Message envoyé", "email" => $email_user];
                }

                else{
                    $response=["attribute" => "error" , "message" => "Une erreur s'est produite lors de l'envoi", "email" => $email_user];
                }

            }

            else{

                $response=["attribute"=> "error", "message" => "Cet utilisateur n'existe pas"];
            }

        }

        else{

            $response=["attribute"=> "error", "message" => "Impossible d'envoyer ce message"];
        }

        echo json_encode($response);
    }


    public function delete_user(){

        if(isset($_POST["id_user"])){
            $user=$this->userManager->get_user("id",$_POST['id_user']);

            if($user != false){

                if($this->userManager->delete_account($_POST["id_user"]) > 0){

                    $response=["attribute" => "success", "message" => "Le compte de cet utilisateur a été supprimé"];
                    $content_email=Tools::generate_email("supression_du_compte",["pseudo" => $user->pseudo]);
                    Tools::sendEmail($user->email,"Suppression du compte",$content_email);
                }

               else{
                    $response=["attribute" => "error" , "message" => "L'utilisateur n'as pas été supprimé suite à un problème technique"];
                }
            }

            else{
                $response=["attribute" => "error" , "message" => "Cet utilisateur n'existe pas"];
            }
        }

        else{
            $response=["attribute"=> "error","message" => "Impossible d'executer cette action"];
        }

       

        echo json_encode($response);
    }


    public function show_edit_article($params){

        $id=$params[1];

        $article=$this->articleManager->getArticle($id);

        if( $article != null){

            $this->view("article_edit", ["article" => $article]);

        }
        

    }
}