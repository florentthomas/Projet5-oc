<?php

namespace App\Controllers;


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

            $this->userManager->update_user("email",$_POST["new_email"],$_SESSION["user"]->id);
            $this->userManager->update_user("account_confirmed",0,$_SESSION["user"]->id);

            $this->send_email_to_confirm($_POST["new_email"],$_SESSION["user"]->key_confirm);

            $response=["attribute"=>"success","message"=>"Adresse email modifiée, confirmez votre adresse dans votre boitre email"];
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
    
            $message=["attribute" => "success", "message" => "Confirmez la suppression du compte sur le mail envoyé"];
            $this->send_email_to_delete($_SESSION["user"]->email,$key_account);
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
}