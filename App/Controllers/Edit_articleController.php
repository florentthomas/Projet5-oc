<?php

namespace App\Controllers;

use App\Tools\Tools;


class Edit_articleController extends Controller{

    public function __construct(){
        $this->articleManager= $this->model("ArticleManager");
        $this->userManager= $this->model("UserManager");
        $this->commentManager=$this->model("CommentManager");
    }


    public function index(){

        if(isset($_SESSION["user"])){
            
            $current_user=$this->userManager->get_user("id",$_SESSION["user"]->id);

            if($current_user->type_user === "admin" || $current_user->type_user === "super_admin" || $current_user->type_user === "editor"){

                $articles=$this->articleManager->get_all_articles();

                $this->view("list_article_edit", ["articles" => $articles]); 
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


    public function panel_edit_article($params){



        if(isset($_SESSION["user"])){
            
            $current_user=$this->userManager->get_user("id",$_SESSION["user"]->id);

            if($current_user->type_user === "admin" || $current_user->type_user === "super_admin" || $current_user->type_user === "editor"){

                $id=$params[1];

                $article=$this->articleManager->get_article_by_id($id);

                if( $article != null){
                    
                    $this->view("article_edit", ["article" => $article]);

                }else{
                    header('HTTP/1.0 404 Not Found');
                    $this->view("404");
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

        
        if($current_user->type_user !== "admin" && $current_user->type_user !== "editor" && $current_user->type_user !== "super_admin"){

            header("403 Forbidden", false , 403);
            $response=["attribute" => "error", "message" => "Vous n'êtes pas autorisé à faire cette action", "redirect" => URL];
            echo json_encode ($response);
            exit();

        }
        

    }


    public function change_title(){

        $this->is_allowed();

        if(isset($_POST["title_article"]) && isset($_POST["id_article"]) && !empty($_POST["title_article"])){
            $titre=htmlspecialchars($_POST["title_article"]);
            $article=$this->articleManager->get_article_by_id($_POST["id_article"]);

            if($article != null){

                if($this->articleManager->edit_article("title",$titre,$_POST["id_article"])){
                    $response=["attribute" => "success" , "message" => "Le titre a bien été modifié"];
                }
                else{
                    $response=["attribute" => "error" , "message" => "Un problème est survenu, modification impossible"];
                }
                
            }

            else{
                $response=["attribute" => "error" , "message" => "L'article n'existe pas"];
            }

        }
        else{
            $response=["attribute" => "error", "message" => "Toutes les informations ne sont pas renseignées"];
        }


        echo json_encode($response);
    }


    public function change_slug(){

        $this->is_allowed();

        if(isset($_POST["slug_article"]) && isset($_POST["id_article"]) && !empty($_POST["slug_article"])){

            $slug=Tools::slug_format($_POST["slug_article"]);
            $article=$this->articleManager->get_article_by_id($_POST["id_article"]);

            if($article != null){

                if($this->articleManager->edit_article("slug",$slug,$_POST["id_article"])){
                    $response=["attribute" => "success" , "message" => "Le slug a bien été modifié"];
                }
                else{
                    $response=["attribute" => "error" , "message" => "Un problème est survenu, modification impossible"];
                }
                
            }

            else{
                $response=["attribute" => "error" , "message" => "L'article n'existe pas"];
            }

        }
        else{
            $response=["attribute" => "error", "message" => "Toutes les informations ne sont pas renseignées"];
        }


        echo json_encode($response);
    }


    public function change_photo(){

        $this->is_allowed();

        if(isset($_FILES["image_article"]) && !empty($_FILES["image_article"]["name"])){

            $article=$this->articleManager->get_article_by_id($_POST["id_article"]);

            if($article != null){

                $response=Tools::add_picture($_FILES["image_article"],PATH_IMG_ARTICLE);

                if($response["attribute"] === "success"){

                    $name_photo=$response["name_photo"];
    
                    if($this->articleManager->edit_article("image_article",$name_photo,$_POST["id_article"])){
                        $response=["attribute" => "success", "message" => "Image modifiée avec succès"];
                    }
    
                    else{
                        $response=["attribute" => "error", "message" => $response["message"]];
                    }
                }
            }
            else{

                $response=["attribute" => "error" , "message" => "L'article n'existe pas"];
            }   
        }
        else{
            $response=["attribute" => "error", "message" => "Toutes les informations ne sont pas renseignées"];
        }

        echo json_encode($response);
    }


    public function change_description(){

        $this->is_allowed();

        if(isset($_POST["description"]) && !empty($_POST["description"])){

            $article=$this->articleManager->get_article_by_id($_POST["id_article"]);

            if($article != null){

                $description=strip_tags($_POST["description"]);


                if($this->articleManager->edit_article("description_article",$description,$_POST["id_article"])){
                    $response=["attribute" => "success", "message" => "Description modifiée avec succès"];
                }

                else{
                    $response=["attribute" => "error", "message" => "Un problème est survenu, impossible de modifier la description"];
                }
                
            }
            
            else{

                $response=["attribute" => "error" , "message" => "L'article n'existe pas"];
            } 


        }

        echo json_encode($response);
    }


    public function change_content(){

        $this->is_allowed();

        if(isset($_POST["content_article"]) && !empty($_POST["content_article"])){

            $article=$this->articleManager->get_article_by_id($_POST["id_article"]);

            
            if($article != null){

                if($this->articleManager->edit_article("content",$_POST["content_article"],$_POST["id_article"])){
                   
                    $response=["attribute" => "success", "message" => "Article modifié avec succès"];
                }

                else{
                    $response=["attribute" => "error", "message" => "Un problème est survenu, impossible de modifier le contenu"];
                }
                
            }
            
            else{

                $response=["attribute" => "error" , "message" => "L'article n'existe pas"];
            } 


        }

        else{
            $response=["attribute" => "error" , "message" => "L'article n'existe pas"];
        }


        echo json_encode($response);
    }


    public function delete_article(){

        $this->is_allowed();

        if(isset($_POST["id_article"]) && !empty($_POST["id_article"])){

            $article=$this->articleManager->get_article_by_id($_POST["id_article"]);

            if($article != null){

                $this->articleManager->delete_article($_POST["id_article"]);
                $this->commentManager->delete_comments_by_article($_POST["id_article"]);
                $response=["attribute" => "success", "message" => "L'article a été supprimé", "redirect" => URL."admin_blog/modifier_article"];
                
            }
            else{
                $response=["attribute" => "error", "message" => "L'article n'existe pas"];
            }


        }
        else{
            $response=["attribute" => "error", "message" => "L'article n'a pas été supprimé"];
        }


        echo json_encode ($response);

    }

}