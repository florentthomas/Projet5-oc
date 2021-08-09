<?php

namespace App\Controllers;

use App\Tools\Tools;


class UserController extends Controller{

    public function __construct(){
        $this->userManager=$this->model("UserManager");
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
        
        if(!isset($_SESSION["user"])){
            echo json_encode(['location'=>URL]);
            exit();
        }

        $current_user=$this->userManager->get_user("id",$_SESSION["user"]->id);

        if($current_user == false){
            echo json_encode(['location'=>URL]);
            exit();
        }

        $new_pseudo=strip_tags($_POST["new_pseudo"]);

        if(!$this->userManager->pseudo_exists($new_pseudo)){

            $this->userManager->update_user("pseudo",$new_pseudo,$current_user->id);

            $_SESSION["user"]->pseudo=$new_pseudo;

            $response=["attribute"=>"success","message"=>"Pseudo modifié"];
        }
        else{
            $response=["attribute"=>"error","message"=>"Le pseudo existe déjà, modification impossible"];
        }

        echo json_encode($response);

    }


    public function email(){

        if(!isset($_SESSION["user"])){
            echo json_encode(['location'=>URL]);
            exit();
        }

        $current_user=$this->userManager->get_user("id",$_SESSION["user"]->id);

        if($current_user == false){
            echo json_encode(['location'=>URL]);
            exit();
        }

        if(filter_var($_POST["new_email"],FILTER_VALIDATE_EMAIL)){

            if($_POST["new_email"] !== $current_user->email){

                if(!$this->userManager->email_exists($_POST["new_email"])){

                    $content_email=Tools::generate_email("confirm_new_email",array("key_account"=>$current_user->key_confirm));

                    if(Tools::sendEmail($_POST["new_email"],"Confirmez votre nouvelle adresse",$content_email)){

                        $this->userManager->update_user("email",$_POST["new_email"],$current_user->id);
                        $this->userManager->update_user("account_confirmed",0,$current_user->id);
                        $_SESSION["user"]->email=$_POST["new_email"];
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

        echo json_encode($response);
    }


    public function confirm_email($key){


        $key=$key[1];

        try{
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

        catch(\Exception $e){
            $message=$e->getMessage();
            header('HTTP/1.0 404 Not Found');
            $this->view("Exception",array("message_exception" => $message));
        
        }
    }


    public function password(){

        if(!isset($_SESSION["user"])){
            echo json_encode(['location'=>URL]);
            exit();
        }

        $current_user=$this->userManager->get_user("id",$_SESSION["user"]->id);

        if($current_user == false){
            echo json_encode(['location'=>URL]);
            exit();
        }


        if(password_verify($_POST["current_password"], $current_user->password_account)){

            $new_password=password_hash($_POST["new_password"],PASSWORD_DEFAULT);
            $this->userManager->update_user("password_account",$new_password,$current_user->id);
            $response=["attribute"=>"success","message"=>"Mot de passe modifié avec succès"];
        }

        else{
            $response=["attribute"=>"error","message"=>"Votre mot de passe actuel n'est pas bon"];
        }
        
        echo json_encode($response);
    }


    public function delete_account($params){

        
        $key_account=$params[1];

        $current_user=$this->userManager->get_user("key_confirm",$key_account);

        if($current_user == false){
            echo json_encode(['location'=>URL]);
            exit();
        }


        if($current_user ==! false){

            $content_email=Tools::generate_email("delete_account",array("key_account"=>$key_account));

            if(Tools::sendEmail($current_user->email,"Suppression du compte",$content_email)){
                $message=["attribute"=>"success", "message"=>"Email envoyé, veuillez cliquer sur le lien pour confirmer"];
            }

            else{
                $message=["attribute"=>"error", "message"=>"Problème technique"];
            }

        }

        else{
            $message=["attribute"=>"error", "message"=>"Utilisateur introuvable"];
        }

         echo json_encode($message);

    }


    public function confirm_delete_account($params){


        $key=$params[1];


        try{
            if(is_numeric($key)){

                $user=$this->userManager->get_user("key_confirm",$key);


                if($user ==! false){

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

        catch(\Exception $e){
            $message=$e->getMessage();
            header('HTTP/1.0 404 Not Found');
            $this->view("Exception",array("message_exception" => $message));
        
        }
        
    }

    public function picture_account(){

        if(!isset($_SESSION["user"])){
            echo json_encode(['location'=>URL]);
            exit();
        }

        $current_user=$this->userManager->get_user("id",$_SESSION["user"]->id);

        if($current_user == false){
            echo json_encode(['location'=>URL]);
            exit();
        }
        
        if(isset($_FILES["photo"]) && !empty($_FILES["photo"]["name"])){

            $extensionsValides = array('jpg', 'jpeg', 'gif', 'png');

            $extensionFile_explode=explode('.',$_FILES["photo"]["name"]);

            $extension_photo=strtolower(end($extensionFile_explode));

            $maxSize=2097152;


            if(in_array($extension_photo,$extensionsValides)){

                if($_FILES["photo"]["size"] < $maxSize){

                    $path_photo=PATH_ROOT."Public/images/avatars/".$current_user->id.".".$extension_photo;
                
                    if($_FILES["photo"]["error"] == 0){

                        if(move_uploaded_file($_FILES["photo"]["tmp_name"], $path_photo)){
                        
                            $url_photo=URL."Public/images/avatars/".$current_user->id.".".$extension_photo;
                            $this->userManager->update_user("url_photo",$url_photo,$current_user->id);
                            $_SESSION["user"]->url_photo= $url_photo;
                            
                            $response=["attribute"=>"success","message"=>"La photo de profil importée avec succès"];
                        }
        
                        else{
                            $response=["attribute"=>"error","message"=>"La photo de profil n'a pas été importée"];
                        }
                    }
                    else{
                        $response=["attribute"=>"error","message"=>"Une erreur s'est produite, l'importation de la photo echouée"];
                    }
                }
                else{
                    $response=["attribute"=>"error","message"=>"La photo doit faire moins de 2 Mo"];
                }
            }
            else{
                $response=["attribute"=>"error", "message"=>"Seuls les fichiers jpg, jpeg, gif et png sont autorisés"];
            }
           
        }
        else{
            $response=["attribute"=>"error","message"=>"Veuillez sélectionner une photo"];
        }

        echo json_encode($response);
    }

    public function password_forgot(){

        if(!empty($_POST["email"]) && filter_var($_POST["email"],FILTER_VALIDATE_EMAIL)){
            

            if($this->userManager->email_exists($_POST["email"])){

                $current_user=$this->userManager->get_user("email",$_POST["email"]);

                $content_email=Tools::generate_email("reset_password",array("key_account"=>$current_user->key_confirm));

                if(Tools::sendEmail($current_user->email,"Réinitialiser le mot de passe",$content_email)){
                    $message=["attribute"=>"success", "message"=>"Email envoyé, veuillez cliquer sur le lien pour confirmer"];
                }

                else{
                    $message=["attribute"=>"error", "message"=>"Problème technique"];
                }
                    $_SESSION["flash"]["response"]=["attribute"=>"success","message"=>"Email envoyé"];
            }

            else{
                $_SESSION["flash"]["response"]=["attribute"=>"error","message"=>"L'adresse email ne corresponds à aucun utilisateur"];
            }
        }

        $this->view("Forgot_password");

    }


    public function reset_password($params){
     
        $key=$params[1];

        try{
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

        catch(\Exception $e){
            $message=$e->getMessage();
            header('HTTP/1.0 404 Not Found');
            $this->view("Exception",array("message_exception" => $message));
        
        }
    }

    public function reset_password_apply(){

        if(isset($_POST["key_account"])){

            
            $current_user=$this->userManager->get_user("key_confirm",$_POST["key_account"]);

            if($current_user){

                if(isset($_POST["new_password"]) && isset($_POST["confirm_password"]) && $_POST["new_password"] === $_POST["confirm_password"]){

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