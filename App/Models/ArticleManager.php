<?php

namespace App\Models;


class ArticleManager extends Manager{

    public function getArticle($id){

        $this->prepare("SELECT * FROM articles WHERE id =:id");
        $this->execute_query_prepared(["id" => $id]);
        $result=$this->get_one();

        return $result;
    }
}