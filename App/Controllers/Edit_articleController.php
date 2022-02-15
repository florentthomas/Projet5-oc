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

}