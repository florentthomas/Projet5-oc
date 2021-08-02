<?php

namespace App\Controllers;

use App\Tools\Tools;


class UserController extends Controller{

    public function __construct(){
        $this->userManager=$this->model("UserManager");
    }

    public function index(){

        $this->view("User_setting");
        

    }

    public function pseudo(){

        if(!$this->userManager->pseudo_exists($_POST["new_pseudo"])){

            $this->userManager->update_user("pseudo",$_POST["new_pseudo"],$_SESSION["user"]->id);

            $response=["attribute"=>"success","message"=>"Pseudo modifié"];
        }
        else{
            $response=["attribute"=>"error","message"=>"Le pseudo existe déjà, modification impossible"];
        }

        echo json_encode($response);
    
    }

    public function email(){

        if(filter_var($_POST["new_email"],FILTER_VALIDATE_EMAIL)){

            if($_POST["new_email"] !== $_SESSION["user"]->email){

                $this->userManager->update_user("email",$_POST["new_email"],$_SESSION["user"]->id);
                $this->userManager->update_user("account_confirmed",0,$_SESSION["user"]->id);

                // $this->send_email_to_confirm($_POST["new_email"],$_SESSION["user"]->key_confirm);

                $response=["attribute"=>"success","message"=>"Adresse email modifiée, confirmez votre adresse dans votre boitre email"];

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

    public function send_email_to_confirm($email,$key){

        $header="MIME-Version: 1.0\r\n";
        $header.='From: "cineFilm.com" <support@cinefilm.com>'."\n";
        $header.='Content-Type:text/html; charset="utf-8"'."\n";
        $header.='Content-Transfer-Encoding: 8bit';

        $url=URL."confirm_new_email/".$key;

        $message="
        
            <html>
                <body>
                    <div>
                        <h1>Confirmez votre nouvelle adresse email en cliquant sur le lien</h1>
                        <a href=".$url.">Confirmer l'adresse email</a>
                    </div>
                </body>
            </html>
        
        ";

        mail($email,"Confirmation adresse email", $message, $header);
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

            $this->view("Exception",array("message_exception" => $message));
        
        }
    }


    public function password(){

        if(password_verify($_POST["current_password"], $_SESSION['user']->password_account)){

            $new_password=password_hash($_POST["new_password"],PASSWORD_DEFAULT);
            $this->userManager->update_user("password_account",$new_password,$_SESSION['user']->id);
            $response=["attribute"=>"success","message"=>"Mot de passe modifié avec succès"];
        }

        else{
            $response=["attribute"=>"error","message"=>"Votre mot de passe actuel n'est pas bon"];
        }
        
        echo json_encode($response);
    }

    public function delete_account($params){
        
        $key_account=$params[1];

        $user=$this->userManager->get_user("key_confirm" , $key_account);

        if($user ==! false){

            $content_email="<h1>Hello</h1>";

            if(Tools::sendEmail($_SESSION["user"]->email,"Suppression du compte",$content_email)){
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

    public function send_email_to_delete($email,$key){

        $header="MIME-Version: 1.0\r\n";
        $header.='From: "cineFilm.com" <support@cinefilm.com>'."\n";
        $header.='Content-Type:text/html; charset="utf-8"'."\n";
        $header.='Content-Transfer-Encoding: 8bit';

        $url=URL."confirm_delete_account/".$key;

        $message="
        
            <html>
                <body>
                    <div>
                        <h1>Confirmez la suppression de votre compte</h1>
                        <a href=".$url.">Supprimer définitivement mon compte</a>
                        <p>La suppression du compte est irreversible, il sera impossible de le récupérer</p>
                        <p>Si vous souhaitez conserver votre compte, ne tenez pas compte de cet email et ne cliquez surtout pas sur le lien</p>
                    </div>
                </body>
            </html>
        
        ";

        mail($email,"Suppression du compte", $message, $header);
    }

    public function confirm_delete_account($params){


        $key=$params[1];

        try{
            if(is_numeric($key)){

                $user=$this->userManager->get_user("key_confirm",$key);


                if($user ==! false){

                    $this->userManager->delete_account($user->id);
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
            $this->view("Exception",array("message_exception" => $message));
            header('HTTP/1.0 404 Not Found');
        
        }
        
    }

    public function picture_account(){

        
        if(isset($_FILES["photo"]) && !empty($_FILES["photo"]["name"])){

            $extensionsValides = array('jpg', 'jpeg', 'gif', 'png');

            $extensionFile_explode=explode('.',$_FILES["photo"]["name"]);

            $extension_photo=strtolower(end($extensionFile_explode));

            $maxSize=3000000;

            

            if(in_array($extension_photo,$extensionsValides)){

                if($_FILES["photo"]["size"] < $maxSize){

                    $path_photo=PATH_ROOT."Public/images/avatars/".$_SESSION["user"]->id.".".$extension_photo;

                    if($_FILES["photo"]["error"] =! 0){

                        if(move_uploaded_file($_FILES["photo"]["tmp_name"], $path_photo)){
                        
                            $url_photo=URL."Public/images/avatars/".$_SESSION["user"]->id.".".$extension_photo;
                            $this->userManager->update_user("url_photo",$url_photo,$_SESSION["user"]->id);
                            
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
                    $response=["attribute"=>"error","message"=>"La photo doit faire moins de 3 Mo"];
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
}