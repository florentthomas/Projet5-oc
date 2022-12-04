<?php

namespace App\Controllers;

use App\Tools\Tools;

class summernoteController extends Controller{

    public function __construct(){
        $this->articleManager= $this->model("ArticleManager");
    }


    public function upload_image(){

        
        if(isset($_FILES["file"]) && !empty($_FILES["file"])){

            $send_image=Tools::add_picture($_FILES["file"],PATH_IMG_ARTICLE);

            if($send_image["attribute"] == "success"){
                $url_image=URL_IMG_ARTICLE.$send_image["name_photo"];
            }
            $response=["url_image" => $url_image];
        }
        else{
            $response=["attribute" => "error", "message" => "Erreur, image non sauvegardée"];
        }
      
        echo json_encode($response);
    }


}