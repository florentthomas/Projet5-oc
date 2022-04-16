<?php

namespace App\Models;


class ArticleManager extends Manager{

    public function getArticle($id){

        $sth=$this->bdd->prepare("SELECT * FROM articles WHERE id =:id");
        $sth->execute(["id" => $id]);
        $result=$sth->fetch();

        return $result;
    }

    public function get_all_articles(){
        $sth=$this->bdd->prepare("SELECT * FROM articles ORDER BY date_create DESC");
        $sth->execute();
        $articles= $sth->fetchAll();

        return $articles;
    }

    public function edit_article($field,$new_value,$id){

        $sth=$this->bdd->prepare("UPDATE articles SET $field = :new_value , date_update=NOW() WHERE id=:id");

        $sth->execute(Array("id" => $id,
                            "new_value" => $new_value));

    
        $count=$sth->rowCount();

        if($count >= 1){
            return true;
        }

        else{
            return false;
        }
    }


    public function edit_content($id,$content){

        $sth=$this->bdd->prepare("UPDATE articles SET content = :new_content , date_update=NOW() WHERE id=:id");

        $sth->execute(Array("id" => $id,
                            "new_content" => $content));


        $count=$sth->rowCount();

        if($count >= 1){
            return true;
        }

        else{
            return false;
        }

    }
}