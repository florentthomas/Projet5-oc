<?php

namespace App\Models;

class CommentManager extends Manager{


    public function getCommentsByArticle($id){

        $sth=$this->bdd->prepare("SELECT * FROM comments_articles WHERE id_article =:id ORDER BY date_comment DESC");
        $sth->execute(["id" => $id]);

        $result=$sth->fetchAll();

        return $result;

    }


    public function getCommentsPagination($id, $perPage, $offset){

        $sth=$this->bdd->prepare("SELECT * FROM comments_articles WHERE id_article =:id AND id_parent = 0 ORDER BY date_comment DESC LIMIT $perPage OFFSET $offset");
        $sth->execute(["id" => $id]);

        $result=$sth->fetchAll();

        return $result;

    }



    public function getCommentsChildren($comment_id){

        $sth=$this->bdd->prepare("SELECT * FROM comments_articles WHERE id_parent =:comment_id");
        $sth->execute(["comment_id" => $comment_id]);

        $result=$sth->fetchAll();

        return $result;

    }

    public function add_comment($comment,$id_parent,$id_user,$id_article,$users_report){

       

        $sth=$this->bdd->prepare("INSERT INTO comments_articles (comment,id_parent,date_comment,id_user,id_article,users_report)
                        VALUES (:comment,:id_parent,NOW(),:id_user,:id_article,:users_report)");

        $values=array("comment" => $comment,
                    "id_parent"=> $id_parent,
                    "id_user" => $id_user,
                    "id_article" => $id_article,
                    "users_report" => $users_report);

        $sth->execute($values);

        $id= $this->bdd->lastInsertId();

        return $id;
        

        
    }

    public function get_comments_reported(){

        $sth=$this->bdd->query("SELECT * FROM comments_articles WHERE count_reported > 0");

        $comments = $sth->fetchAll();

        return $comments;

    }


    public function report_comment($id_comment,$users_report){

        $sth=$this->bdd->prepare("UPDATE comments_articles SET count_reported = count_reported + 1 , users_report = :users_report WHERE id = :id_comment");

        $sth->execute(Array("users_report" => $users_report, "id_comment" => $id_comment));
        
    }


    public function get_comment($id_comment){

        $sth=$this->bdd->prepare("SELECT * FROM comments_articles WHERE id = :id");

        $sth->execute(Array("id" => $id_comment));

        $comment=$sth->fetch();

        return $comment;

    }


    public function delete_comments($id_comments){

        $sth=$this->bdd->prepare("DELETE FROM comments_articles WHERE id = :id_comment");

        foreach($id_comments as $id_comment){
            $sth->execute(Array("id_comment" => $id_comment));

        }
    }

    public function approve_comment($id_comment,$users_report){

        $sth=$this->bdd->prepare("UPDATE comments_articles SET count_reported = 0, users_report = :users_report  WHERE id = :id_comment");

        $sth->execute(Array("users_report" => $users_report, "id_comment" => $id_comment));
    }

}