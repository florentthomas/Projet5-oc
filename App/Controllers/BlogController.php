<?php

namespace App\Controllers;


class BlogController extends Controller{

    public function __construct(){

        $this->userManager=$this->model("UserManager");
    }

    public function index(){

        $this->view("BlogHome",array("titre" => "titre d'un article"));
    }


    public function connection(){

        if(isset($_SESSION["flash"]["error_connect"])){
           unset($_SESSION["flash"]["error_connect"]);
        }

        if($_SERVER['REQUEST_METHOD'] === "POST" && !empty($_POST["email"]) && !empty($_POST["password"])){

            $user=$this->userManager->get_user_email($_POST["email"]);
            
            if($user !== false && password_verify($_POST["password"], $user->password_account)){

                    $_SESSION["user"]=$user;
                    header("Location:".URL);   
            }
            else{
                $_SESSION["flash"]["error_connect"]="Mot de passe ou adresse email invalides";
            }

        }
        $this->view("Connection");
    }

    public function disconnect(){
        unset($_SESSION["user"]);
        session_destroy();
        header("Location:".URL);
    }
}