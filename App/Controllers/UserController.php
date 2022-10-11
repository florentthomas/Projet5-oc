<?php

namespace App\Controllers;

use App\Tools\Email;
use App\Tools\Tools;


class UserController extends Controller{

    public function __construct(){
        $this->userManager=$this->model("UserManager");
    }

    private function is_connected(){

        if(!isset($_SESSION["user"])){
            echo json_encode(['location'=>URL]);
            exit();
        }

    }

    private function get_current_user($id){

        $current_user=$this->userManager->get_user("id",$id);

        if($current_user == false){

            if(isset($_SESSION["user"])){
                unset($_SESSION["user"]);
                session_destroy();
            }

            echo json_encode(['location'=>URL]);
            exit();
        }

        return $current_user;
    }

    public function index(){
        
        if(isset($_SESSION["user"])){
            $this->view("User_setting");
        }
        else{
            header("Location:".URL);
        }
    }

    public function pseudo(){
        
        $this->is_connected();

        $current_user=$this->get_current_user($_SESSION["user"]->id);


        if(isset($_POST["new_pseudo"]) && !empty($_POST["new_pseudo"])){

            $new_pseudo=strip_tags($_POST["new_pseudo"]);

            if(!$this->userManager->pseudo_exists($new_pseudo)){

                $this->userManager->update_user("pseudo",$new_pseudo,$current_user->id);

                $_SESSION["user"]->pseudo=$new_pseudo;

                $response=["attribute"=>"success","message"=>"Pseudo modifié"];
            }
            else{
                $response=["attribute"=>"error","message"=>"Le pseudo existe déjà, modification impossible"];
            }
        }

        else{
            $response=["attribute"=>"error","message"=>"Veuillez renseigner votre nouveau pseudo"];
        }

        echo json_encode($response);

    }


    public function email(){

        $this->is_connected();

        $current_user=$this->get_current_user($_SESSION["user"]->id);


        if(isset($_POST["new_email"]) && isset($_POST["email_confirm"]) && !empty($_POST["new_email"]) && !empty($_POST["email_confirm"])){


            if($_POST["new_email"] === $_POST["email_confirm"]){


                if(filter_var($_POST["new_email"],FILTER_VALIDATE_EMAIL)){

                    if($_POST["new_email"] !== $current_user->email){

                        if(!$this->userManager->email_exists($_POST["new_email"])){


                            $content_email=Email::generate_email("confirm_new_email",array("key_account"=>$current_user->key_confirm, "name" => $current_user->pseudo));

                            if(Email::sendEmail($_POST["new_email"],"Confirmez votre nouvelle adresse",$content_email)){

                                $this->userManager->update_user("email",$_POST["new_email"],$current_user->id);
                                $this->userManager->update_user("account_confirmed",0,$current_user->id);
                                $_SESSION["user"]->email=$_POST["new_email"];
                                $_SESSION["user"]->account_confirmed=0;
                                $response=["attribute"=>"success", "message"=>"Email envoyé, veuillez cliquer sur le lien pour confirmer"];
                            }
                            else{
                                $response=["attribute"=>"error","message"=>"Une erreur s'est produite"];
                            }
                        }
                        else{
                            $response=["attribute"=>"error","message"=>"Adresse email déjà utilisée par un autre compte"];
                        }
                    }
                    else{
                        $response=["attribute"=>"error","message"=>"Vous avez renseigné votre adresse email actuelle"];
                    }
                }
                else{
                    $response=["attribute"=>"error","message"=>"Adresse email non valide"];
                }
            }
            else{
                $response=["attribute"=>"error","message"=>"Les adresses email ne sont pas identiques"];
            }
        }

        else{
            $response=["attribute"=>"error","message"=>"Vous devez renseigner une adresse email"];
        }

        echo json_encode($response);
    }


    public function confirm_email($key){


        $key=$key[1];

      
        if(is_numeric($key)){

            $user=$this->userManager->get_user("key_confirm",$key);

            if($user ==! false){

                if($user->account_confirmed == 0){
                    $this->userManager->confirm_account($user->id);
                    $this->view("Confirm_email");
                }

                else{
                    header("Location:".URL);
                }

            }
            else{
                throw new \Exception("Le profil n'a pas été trouvé");
            }  
        }
        else{
            throw new \Exception("Clé non valide");
        }

        

       
    }


    public function password(){

        $this->is_connected();

        $current_user=$this->get_current_user($_SESSION["user"]->id);

        if(isset($_POST["current_password"]) && isset($_POST["new_password"]) && isset($_POST["confirm_new_password"]) && !empty($_POST["current_password"]) && !empty($_POST["new_password"]) && !empty($_POST["confirm_new_password"])){

            if($_POST["new_password"] === $_POST["confirm_new_password"]){

                if(password_verify($_POST["current_password"], $current_user->password_account)){

                    $new_password=password_hash($_POST["new_password"],PASSWORD_DEFAULT);
                    $this->userManager->update_user("password_account",$new_password,$current_user->id);
                    $response=["attribute"=>"success","message"=>"Mot de passe modifié avec succès"];
                }

                else{
                    $response=["attribute"=>"error","message"=>"Votre mot de passe actuel n'est pas bon"];
                }
            }

            else{
                $response=["attribute"=>"error","message"=>"Les deux mots de passe ne sont pas identiques"];
            }

        }

        else {
            $response=["attribute"=>"error","message"=>"Les champs ne sont pas tous remplis"];
        }
        
        echo json_encode($response);
    }


    public function delete_account(){


        $this->is_connected();

        $current_user=$this->get_current_user($_SESSION["user"]->id);
   

        $content_email=Email::generate_email("delete_account",array("key_account"=>$current_user->key_confirm, "name" => $current_user->pseudo));

        if(Email::sendEmail($current_user->email,"Suppression du compte",$content_email)){
            $message=["attribute"=>"success", "message"=>"Email envoyé, veuillez cliquer sur le lien pour confirmer"];
        }

        else{
            $message=["attribute"=>"error", "message"=>"Echec lors de l'envoie du mail, suppression impossible"];
        }

      
         echo json_encode($message);

    }


    public function confirm_delete_account($params){


        $key=$params[1];


        
        if(is_numeric($key)){

            $user=$this->userManager->get_user("key_confirm",$key);


            if($user ==! false){

                if($user->photo !== "default.svg"){
                    unlink(PATH_IMG_AVATARS."/".$user->photo);
                }

                $this->userManager->delete_account($user->id);

                if(isset($_SESSION["user"])){
                    unset($_SESSION["user"]);
                    session_destroy();
                }

                $this->view("delete_account");
            }
            else{
                throw new \Exception("Le profil n'a pas été trouvé");
            }
        }

        else{
            throw new \Exception("Clé non valide");
        }

        
    }

    public function picture_account(){

        $this->is_connected();

        $current_user=$this->get_current_user($_SESSION["user"]->id);

        
        
        if(isset($_FILES["photo"]) && !empty($_FILES["photo"]["name"])){


            $send_image=Tools::add_picture($_FILES["photo"], PATH_IMG_AVATARS);

            

            if($send_image["attribute"] === "success"){

                $response=["attribute" => "success", "message" => "Photo de profil modifié"];

                $name_photo=$send_image["name_photo"];

                $this->userManager->update_user("photo",$name_photo,$current_user->id);

                if($_SESSION["user"]->photo !== "Default.svg"){
                    unlink(PATH_IMG_AVATARS."/".$_SESSION["user"]->photo);
                }
                

                $_SESSION["user"]->photo= $name_photo;

            }
            else{
                $response=["attribute"=>"error","message"=>$send_image["message"]];
            }

            
        }
        else{
            $response=["attribute"=>"error","message"=>"Veuillez sélectionner une photo"];
        }

        echo json_encode($response);
    }



    public function password_forgot(){


        if(isset($_POST["email"])){

            if(!empty($_POST["email"]) && filter_var($_POST["email"],FILTER_VALIDATE_EMAIL)){
            

                if($this->userManager->email_exists($_POST["email"]) ==! false){
    
                    $current_user=$this->userManager->get_user("email",$_POST["email"]);
    
                    $content_email=Email::generate_email("reset_password",array("key_account"=>$current_user->key_confirm, "name" => $current_user->pseudo));
    
                    if(Email::sendEmail($current_user->email,"Réinitialiser le mot de passe",$content_email)){
                        $_SESSION["flash"]["response"]=["attribute"=>"success","message"=>"Email envoyé"];
                    }
    
                    else{
                        $_SESSION["flash"]["response"]=["attribute"=>"error","message"=>"Un problème est survenu, echec de l'envoie de l'email"];
                    }
                        
                }
    
                else{
                    $_SESSION["flash"]["response"]=["attribute"=>"error","message"=>"L'adresse email ne corresponds à aucun utilisateur"];
                }
            }
    
            else{
                $_SESSION["flash"]["response"]=["attribute"=>"error","message"=>"Vous devez saisir votre adresse email"];
            }


            header("Location:".URL."password_forgot");
            exit();
            

        }


        $this->view("Forgot_password");

        if(isset($_SESSION["flash"]["response"])){
            unset($_SESSION["flash"]["response"]);
        }

    }


    public function reset_password($params){
     
        $key=$params[1];

        if(is_numeric($key)){

            $user=$this->userManager->get_user("key_confirm",$key);


            if($user ==! false){

                $this->view("reset_password",array("key_account" =>$key));
            }
            else{
                throw new \Exception("Le profil n'a pas été trouvé");
            }
        }

        else{
            throw new \Exception("Clé non valide");
        }
    }

    
    public function reset_password_apply(){

        if(isset($_POST["key_account"]) && !empty($_POST["key_account"])){

            
            $current_user=$this->userManager->get_user("key_confirm",$_POST["key_account"]);

            if($current_user){

                if(isset($_POST["new_password"]) && isset($_POST["confirm_password"]) && !empty($_POST["new_password"]) && !empty($_POST["confirm_password"]) && $_POST["new_password"] === $_POST["confirm_password"]){

                    $new_password=password_hash($_POST["new_password"], PASSWORD_DEFAULT);


                    $this->userManager->update_user("password_account",$new_password,$current_user->id);
                    $response=["attribute"=>"success", "message"=>"Le mot de passe est réinitialisé"];
                }

                else{
                    $response=["attribute"=>"error", "message"=>"Modification impossible"];
                }
                
            }

            else{
                $response=["attribute"=>"error", "message"=>"Utilisateur introuvable"];
            }

        }

        else{
            $response=["attribute"=>"error", "message"=>"Utilisateur introuvable"];
        }

        echo json_encode($response);
    }
}