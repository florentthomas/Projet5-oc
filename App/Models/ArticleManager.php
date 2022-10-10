<?php

namespace App\Models;


class ArticleManager extends Manager{

    public function get_article_by_id($id){

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

    public function get_articles_pagination($perPage,$offset){

        $sth=$this->bdd->prepare("SELECT * FROM articles ORDER BY date_create DESC LIMIT $perPage OFFSET $offset");
        $sth->execute();
        $result=$sth->fetchAll();

        return $result;
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



    public function add_article($title,$slug,$description,$content,$name_image,$author){

        $sth=$this->bdd->prepare("INSERT INTO articles (title,author,description_article,content,slug,image_article) VALUES(:title, :author,:description_article,:content,:slug,:image_article)");

        $sth->execute(Array("title" => $title,
                            "author" =>$author,
                            "description_article" => $description,
                            "content" =>$content,
                            "slug" => $slug,
                            "image_article" => $name_image));
    }
}