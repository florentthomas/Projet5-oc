<?php

namespace App\Controllers;

use App\Tools\Tools;


class Edit_articleController extends Controller{

    public function __construct(){
        $this->articleManager= $this->model("ArticleManager");
    }


    public function index(){

        $articles=$this->articleManager->get_all_articles();

        $this->view("list_article_edit", ["articles" => $articles]); 
    }


    public function panel_edit_article($params){

        $id=$params[1];

        $article=$this->articleManager->getArticle($id);

        if( $article != null){
            
            $this->view("article_edit", ["article" => $article]);

        }
        
    }


    public function change_title(){

        if(isset($_POST["title_article"]) && isset($_POST["id_article"]) && !empty($_POST["title_article"])){
            $titre=htmlspecialchars($_POST["title_article"]);
            $article=$this->articleManager->getArticle($_POST["id_article"]);

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

        if(isset($_POST["slug_article"]) && isset($_POST["id_article"]) && !empty($_POST["slug_article"])){

            $slug=Tools::slug_format($_POST["slug_article"]);
            $article=$this->articleManager->getArticle($_POST["id_article"]);

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

        if(isset($_FILES["image_article"]) && !empty($_FILES["image_article"]["name"])){

            $article=$this->articleManager->getArticle($_POST["id_article"]);

            if($article != null){

                $response=Tools::add_picture($_FILES["image_article"],PATH_IMG_ARTICLE);

                if($response["attribute"] === "success"){

                    $name_photo=$response["name_photo"];
    
                    if($this->articleManager->edit_article("image",$name_photo,$_POST["id_article"])){
                        $response=["attribute" => "success", "message" => "Image modifiée avec succès"];
                    }
    
                    else{
                        $response=["attribute" => "error", "message" => "Un problème est survenu, impossible de modifier l'image"];
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

}