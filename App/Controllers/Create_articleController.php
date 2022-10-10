<?php

namespace App\Controllers;

use App\Tools\Tools;


class Create_articleController extends Controller{

    public function __construct(){
        $this->articleManager= $this->model("ArticleManager");
        $this->userManager= $this->model("UserManager");
    }


    public function index(){

 
         if(isset($_SESSION["user"])){
            
            $current_user=$this->userManager->get_user("id",$_SESSION["user"]->id);

            if($current_user->type_user === "admin" || $current_user->type_user === "super_admin" || $current_user->type_user === "editor"){

                $this->view("create_article");

                if(isset($_SESSION["flash"]["response"])){
                    unset($_SESSION["flash"]["response"]);
                }
            }
            else{
                header("Location:".URL);
                exit();
            }
        }
        else{
            header("Location:".URL);
            exit();
        }
    }

    private function is_allowed(){

   
        $current_user=$this->userManager->get_user("id",$_SESSION["user"]->id);

        
        if($current_user->type_user !== "admin" && $current_user->type_user !== "super_admin" && $current_user->type_user !== "editor"){

            header("403 Forbidden", false , 403);
            $response=["attribute" => "error", "message" => "Vous n'êtes pas autorisé à faire cette action", "redirect" => URL];
            echo json_encode ($response);
            exit();

        }
        

    }

    public function create_article(){

        $this->is_allowed();

        if(isset($_POST["title_article"]) && isset($_POST["slug_article"]) && isset($_POST["description"]) && isset($_POST["content_article"]) && isset($_FILES["image_article"])
            && $_FILES["image_article"]["error"] === 0 && !empty($_POST["title_article"]) && !empty($_POST["slug_article"]) && !empty($_POST["description"]) && !empty($_POST["content_article"])){

                
            $response=Tools::add_picture($_FILES["image_article"],PATH_IMG_ARTICLE);

            if($response["attribute"] == "success"){

                $name_image=$response["name_photo"];
                $title=strip_tags($_POST["title_article"]);
                $slug=Tools::slug_format($_POST["slug_article"]);
                $description=strip_tags($_POST["description"]);
                $content=$_POST["content_article"];
                $author=$_SESSION["user"]->pseudo;



                $this->articleManager->add_article($title,$slug,$description,$content,$name_image,$author);

                $_SESSION["flash"]["response"]=["attribute"=>"success","message"=>"L'article a bien été publié"];

            }

            else{
                $_SESSION["flash"]["response"]=["attribute"=>$response["attribute"],"message"=>$response["message"]];
            }
            

        
            
        }
        else{
           $_SESSION["flash"]["response"]=["attribute"=>"error","message"=>"Les champs ne sont pas tous remplis"];

        }

        header("Location:".URL."admin_blog/creer_article");
       
    }


}