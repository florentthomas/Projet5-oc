<?php

namespace App\Models;


class ArticleManager extends Manager{

    public function getArticle($id){

        $sql="SELECT * FROM articles WHERE id = :id";

        // $query=$this->connect_bdd()->prepare($sql);
        // $query->execute(Array("id" => $id));

        $this->prepare("SELECT * FROM articles WHERE id =:id");
        $this->execute_query_prepared(["id" => $id]);

        $test=$this->get_one();

        var_dump($test);

        $data=$query->fetch();

        if($data){

            $article=new ArticleModel($data);
            return $data;
        }
    
        return false;

        
    }
}