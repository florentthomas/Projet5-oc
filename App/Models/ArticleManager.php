<?php

namespace App\Models;


class ArticleManager extends Manager{

    public function getArticle($id){

        $sth=$this->bdd->prepare("SELECT * FROM articles WHERE id =:id");
        $this->execute(["id" => $id]);
        $result=$sth->fetch();

        return $result;
    }

    public function get_all_articles(){
        $sth=$this->bdd->prepare("SELECT * FROM articles ORDER BY date_create DESC");
        $sth->execute();
        $articles= $sth->get_all();

        return $articles;
    }
}