<?php


namespace App\Controllers;

use App\Tools\Email;


class Admin_usersController extends Controller{

    public function __construct(){
        $this->userManager= $this->model("UserManager");
    }

    private function is_allowed(){

   
        $current_user=$this->userManager->get_user("id",$_SESSION["user"]->id);


        if($current_user == false){
                
            unset($_SESSION["user"]);
            session_destroy();
            header("403 Forbidden", false , 403);
            $response=["attribute" => "error", "message" => "Vous n'êtes plus connecté", "redirect" => URL];
            echo json_encode ($response);
            exit();
        }

        
        if($current_user->type_user !== "admin" && $current_user->type_user !== "super_admin"){

            header("403 Forbidden", false , 403);
            $response=["attribute" => "error", "message" => "Vous n'êtes pas autorisé à faire cette action", "redirect" => URL];
            echo json_encode ($response);
            exit();

        }
        

    }

    public function index(){

        if(isset($_SESSION["user"])){
            
            $current_user=$this->userManager->get_user("id",$_SESSION["user"]->id);

            if($current_user->type_user === "admin" || $current_user->type_user === "super_admin" ){
                $this->view("User_admin");
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


    public function search_user(){


        if(isset($_GET["user"])){

            $user=trim($_GET["user"]);

            $result=$this->userManager->search($user);

            foreach($result as $user){
                $user->photo=URL_IMG_AVATARS.$user->photo;
                $user->pseudo=htmlspecialchars($user->pseudo, ENT_HTML5);
                $user->date_inscription=date("d/m/Y", strtotime($user->date_inscription));
            }


            echo json_encode($result);

        }
        
    }



    public function change_type_user(){

        $this->is_allowed();

        if(isset($_POST["type_user"]) && isset($_POST["id_user"])){

            $type_user=$_POST["type_user"];

            $user=$this->userManager->get_user("id",$_POST['id_user']);

            if($user != false){

                if($user->type_user !== "super_admin"){

                    if($type_user === "user" || $type_user === "editor" || $type_user === "admin"){
    
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
                    $response=["attribute"=> "error", "message" => "Vous ne pouvez pas modifier son statut"];
                }

            }

            else{
                $response=["attribute"=> "error", "message" => "Cet utilisateur n'existe pas"];
            }

            

        }

        else{
            $response=["attribute"=> "error", "message" => "Erreur dans le traitement des données"];
        }
        

        echo json_encode($response);
    }


    public function send_email_to_user(){

        $this->is_allowed();


        if(isset($_POST["message"]) && !empty($_POST["message"]) && isset($_POST["id_user"]) && isset($_POST["subject"]) && !empty($_POST["subject"])){

            $user=$this->userManager->get_user("id",$_POST['id_user']);
            
            if($user != false){

                $email_user=$user->email;

                $content_email=Email::generate_email("contact_user",Array("content" => $_POST["message"],"title" => $_POST["subject"]),$_POST["subject"]);

                if(Email::sendEmail($email_user,mb_encode_mimeheader($_POST["subject"]),$content_email)){
                    $response=["attribute" => "success" , "message" => "Message envoyé", "email" => $email_user];
                }

                else{
                    $response=["attribute" => "error" , "message" => "Une erreur s'est produite lors de l'envoi"];
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

        $this->is_allowed();

        if(isset($_POST["id_user"])){
            $user=$this->userManager->get_user("id",$_POST['id_user']);
            
            if($user != false){

                if($user->type_user !== "super_admin"){

                    if($this->userManager->delete_account($_POST["id_user"]) > 0){

                        $response=["attribute" => "success", "message" => "Le compte de cet utilisateur a été supprimé"];
                        $content_email=Email::generate_email("supression_du_compte",["name" => $user->pseudo]);
                        Email::sendEmail($user->email,"Suppression du compte",$content_email);
                    }
    
                   else{
                        $response=["attribute" => "error" , "message" => "L'utilisateur n'as pas été supprimé suite à un problème technique"];
                    }
                }

                else{
                    $response=["attribute" => "error" , "message" => "Vous ne pouvez pas supprimer cet utilisateur"];
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

}