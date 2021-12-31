<?php

namespace App\Models;

class CommentManager extends Manager{


    public function getCommentsByArticle($id){

        $sth=$this->bdd->prepare("SELECT * FROM comments_articles WHERE id_article =:id ORDER BY date_comment DESC");
        $sth->execute(["id" => $id]);

        $result=$sth->fetchAll();

        return $result;

    }

    public function add_comment($comment,$id_parent,$id_user,$id_article){

        $sth=$this->bdd->prepare("INSERT INTO comments_articles (comment,id_parent,date_comment,id_user,id_article)
                        VALUES (:comment,:id_parent,NOW(),:id_user,:id_article)");

        $values=array("comment" => $comment,
                    "id_parent"=> $id_parent,
                    "id_user" => $id_user,
                    "id_article" => $id_article);

        $sth->execute($values);
    }

}