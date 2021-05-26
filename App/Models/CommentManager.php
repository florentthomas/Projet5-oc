<?php

namespace App\Models;

class CommentManager extends Manager{


    public function getCommentsByArticle($id){

        $this->prepare("SELECT * FROM comments_articles WHERE id_article =:id");
        $this->execute_query_prepared(["id" => $id]);

        $result=$this->get_all();

        return $result;

    }

    

}