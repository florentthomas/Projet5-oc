<?php

namespace App\Controllers;


class AdminController extends Controller{

    public function index(){

        if($_SESSION["user"]->type_user === "admin"){
            $this->view("Admin_blog");
        }

        else{
            header("Location:".URL);
        }

    }


    public function create_article(){

        $this->view("create_article");
    
    }
}