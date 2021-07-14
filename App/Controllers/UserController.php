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

}