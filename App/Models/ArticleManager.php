<?php

namespace App\Models;


class ArticleManager extends Manager{

    public function getArticle($id){

        $this->prepare("SELECT * FROM articles WHERE id =:id");
        $this->execute_query_prepared(["id" => $id]);
        $result=$this->get_one();

        return $result;
    }

    public function get_all_articles(){
        $this->query("SELECT * FROM articles ORDER BY date_create DESC");
        $articles= $this->get_all();

        return $articles;
    }
}