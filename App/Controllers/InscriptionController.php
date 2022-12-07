<?php

namespace App\Controllers;

use App\Tools\Email;

class InscriptionController extends Controller{

    public function __construct(){
        $this->UserManager=$this->model("UserManager");
    }

  
    public function index(){
        $this->view("Inscription");
    }

    public function create_account(){
        
        if(!empty($_POST["pseudo"]) && !empty($_POST["password_1"]) && !empty("email") && !empty($_POST["password_2"])){
        

            if(filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){

                if(!$this->UserManager->email_exists($_POST["email"])){

                    if(!$this->UserManager->pseudo_exists($_POST["pseudo"])){

                        if($_POST["password_1"] === $_POST["password_2"]){

                            $password=password_hash($_POST["password_1"], PASSWORD_DEFAULT);

                            $key="";

                            for($i=0; $i < 16 ; $i++){
                                $key.= mt_rand(0,9);
                            }

                            $pseudo=htmlspecialchars($_POST["pseudo"]);

                            $content_email=Email::generate_email("confirmation_inscription",array("key" => $key, "name" => $pseudo));

                            if(Email::sendEmail($_POST["email"],"Confirmez votre inscription",$content_email)){

                                $this->UserManager->create_account($_POST["pseudo"],$_POST["email"],$password,$key,"default.svg");
                                $response=["attribute"=>"success","message"=>"Compte crée, cliquez sur le lien de confirmation sur le mail envoyé"];
                            }

                            else{
                                $response=["attribute"=>"error","message"=>"Une erreur s'est produite lors de l'envoie du mail"];
                            }
                            
                        }
                        else{
                            $response=["attribute"=>"error","message"=>"Les mot de passes ne sont pas les mêmes"];
                        }
                    }
                    else{
                        $response=["attribute"=>"error","message"=>"Le pseudo est déjà pris"];
                    }
                }
                else{
                    $response=["attribute"=>"error","message"=>"Un compte existant possède cette adresse Email"];
                }
                
            }
            
            else{
                $response=["attribute"=>"error","message"=>"L'adresse Email n'est pas valide"];
            }
        }

        else{
            $response=["attribute"=>"error","message"=>"Le formulaire n'est pas entierement rempli"];
        }

        echo json_encode($response);
        
        
    }


    public function confirm_account($key){

        $key=$key[1];

        try{

            if(isset($key)){
                $current_user=$this->UserManager->get_user("key_confirm", $key);
                
                if($current_user){

                    if($current_user->account_confirmed == 0){

                        if(isset($_SESSION["user"])){
                            
                            $_SESSION["user"]->account_confirmed = 1;

                        }

                        $this->UserManager->confirm_account($current_user->id);
                        $this->view("Confirm_account");
                    }
        
                    else{
                        header("Location:".URL);
                    }

                }
                
                else{
                    throw New \exception("L'utilisateur n'existe pas");
                }
            }
            
            else{
                throw New \exception("Aucune clé pour retrouver l'utilisateur");
            }

        }

        catch(\Exception $e){
            
            $message=$e->getMessage();
            header('HTTP/1.0 404 Not Found');
            $this->view("Exception",array("message_exception" => $message));   
        }
    }

}