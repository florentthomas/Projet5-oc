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

        $data="Formulaire reçue";
                return $data;

        
        if(!empty($_POST["pseudo"]) && !empty($_POST["password_1"]) && !empty("email") && !empty($_POST["password_2"])){
        

            if(filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){

                

                if(!$this->UserManager->email_exists($_POST["email"])){

                    if(!$this->UserManager->pseudo_exists($_POST["pseudo"])){

                        if($_POST["password_1"] === $_POST["password_2"]){
                            $password=password_hash($_POST["password_1"], PASSWORD_DEFAULT);

                        }
                        else{
                            //Les mots de passe ne sont identiques
                        }
                    }
                    else{
                        //Le pseudo est deja pris
                    }
                }
                else{
                    //Le mail exist deja
                }
                
                //requete pour vérifier si le mail est déja present dans la base
            }
            
            else{
                //email non valide
            }
        }

        else{
            //Formulaire n'est pas rempli
        }

        
    }
}