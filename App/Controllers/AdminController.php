<?php

namespace App\Controllers;


class AdminController extends Controller{

    public function __construct(){
        $this->articleManager= $this->model("ArticleManager");
        $this->userManager= $this->model("UserManager");
    }

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


    public function edit_article(){

        $articles=$this->articleManager->get_all_articles();


        $this->view("list_article_edit", ["articles" => $articles]);
    }

    public function user(){
        $this->view("User_admin");
    }

    public function search_user(){


        if(isset($_GET["user"])){

            $user=trim($_GET["user"]);

            $result=$this->userManager->search($user);

            echo json_encode($result);

        }
        
    }


    public function get_user(){

        if(isset($_POST["id_user"])){

            $test="id de l'utilisateur: ".$_POST["id_user"];

            echo json_encode ($test);
        }
    }

    public function change_type_user(){

        if(isset($_POST["type_user"]) && isset($_POST["id_user"])){

            $type_user=$_POST["type_user"];

            $user=$this->userManager->get_user("id",$_POST['id_user']);

        
            if($type_user == "user" || $type_user == "editor" || $type_user="admin"){

                if($user !== false){

                    $request_update_user=$this->userManager->update_user("type_user",$type_user,$_POST["id_user"]);
                    
                    if($request_update_user){

                        $response=["attribute" => "success", "message" => "Changement effectué"];
                    }

                    else{
                        $response=["attribute" => "error", "message" => "Une erreur est survenue lors de l'execution de la requête"];
                    }

                    
                }

                else{
                    $response=["attribute"=>"error","message" => "L'utilisateur n'existe pas"];
                }
            }

            else{
                $response=["attribute"=> "error", "message" => "Type utilisateur non conforme"];
            }

        }

        else{
            $response=["attribute"=> "error", "message" => "Erreur dans le traitement des données"];
        }
        

        echo json_encode($response);
    }
}