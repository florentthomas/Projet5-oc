<?php

namespace App\Controllers;



class InscriptionController extends Controller{

    public function __construct(){
        $this->UserManager=$this->model("UserManager");
    }

  
    public function index(){
        $this->view("Inscription");
    }

    public function check(){
        
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

                         
                            $this->UserManager->create_account($_POST["pseudo"],$_POST["email"],$password,$key);
                            $response=["attribute"=>"success","message"=>"Compte crée, cliquez sur le lien de confirmation sur le mail envoyé"];
                            $this->send_email($_POST["email"], $key);
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

    public function send_email($email,$key){

        $header="MIME-Version: 1.0\r\n";
        $header.='From: "cineFilm.com" <support@cinefilm.com>'."\n";
        $header.='Content-Type:text/html; charset="utf-8"'."\n";
        $header.='Content-Transfer-Encoding: 8bit';

        $url=URL."confirm/".$key;

        $message="
        
            <html>
                <body>
                    <div>
                        <h1>Confirmez votre inscription en cliquant sur le lien</h1>
                        <a href=".$url.">Confirmer l'inscription</a>
                    </div>
                </body>
            </html>
        
        ";

        mail($email,"Confirmation de compte", $message, $header);

    }

}