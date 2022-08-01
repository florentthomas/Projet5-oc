<?php

namespace App\Controllers;


class LoginController extends Controller{



    public function __construct(){

        $this->userManager=$this->model("UserManager");
        
    }


    public function index(){

        if(isset($_SESSION["user"])){
            header("Location:".URL);   
            exit();
        }

        
        $this->url_referer();

      
        $this->view("Connection");


        if(isset($_SESSION["flash"]["error_connect"])){
            unset($_SESSION["flash"]["error_connect"]);
        }

      
    }


    private function url_referer(){

        if(isset($_SERVER['HTTP_REFERER'])){

            

            if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on'){
                $url_current = "https";
            }
    
            else{
                $url_current = "http"; 
            }
    
            $url_current .= "://"; 
            $url_current .= $_SERVER['HTTP_HOST']; 
            $url_current .= $_SERVER['REQUEST_URI'];


            if($_SERVER['HTTP_REFERER'] !== $url_current){
                $_SESSION["redirect"]=$_SERVER['HTTP_REFERER'];
            }
           
 
        }

       
    }



    public function connection(){


        if(isset($_SESSION["user"])){
            header("Location:".URL);  
            exit(); 
        }

      

        if(!empty($_POST["email"]) && !empty($_POST["password"])){

            $user=$this->userManager->get_user_email($_POST["email"]);

            
            if($user !== false && password_verify($_POST["password"], $user->password_account)){



                    $_SESSION["user"]=$user;

                    if(isset($_SESSION["redirect"])){
                        header("Location:".$_SESSION["redirect"]);
                        unset($_SESSION["redirect"]);
                        exit();
                    }

                    else{
                        header("Location:".URL);
                        exit();
                    }
                   
                      
            }
            else{
                $_SESSION["flash"]["error_connect"]="Mot de passe ou adresse email invalides";
            }

        }

        else{
            $_SESSION["flash"]["error_connect"]="Renseignez votre email et mot de passe";
        }


       header("Location:".URL."login");

    }


    public function disconnect(){

        unset($_SESSION["user"]);
        session_destroy();

        header("Location:".URL);
        exit();
        
    }
}