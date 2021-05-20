<?php

namespace App\Models;


class ArticleManager extends Manager{

    public function getArticle($id){

        $sql="SELECT * FROM articles WHERE id = :id";

        $query=$this->connect_bdd()->prepare($sql);
        $query->execute(Array("id" => $id));

        $data=$query->fetch();

        if($data){

            $article=new ArticleModel($data);
            return $data;
        }
    
        return false;

        
    }
}