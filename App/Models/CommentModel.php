<?php

namespace App\Models;

class CommentModel{

    use Hydrate;

    private $_id,
            $_id_article,
            $_id_user,
            $_id_parent,
            $_comment,
            $_date_comment;

    public function __construct($data){
        $this->hydrate($data);
    }

    public function set_id($id){
        if(is_numeric($id) && $id > 0){
            $this->_id=$id;
        }
    }

    public function set_id_article($id_article){
        if(is_numeric($id_article) && $id_article > 0){
            $this->_id_article=$id_article;
        }
    }

    public function set_id_user($id_user){
        if(is_numeric($id_user) && $id_user > 0){
            $this->_id_user=$id_user;
        }
    }

    public function set_id_parent($id_parent){
        
            $this->_id_parent=(int)$id_parent;
        
    }


    public function set_comment($comment){
        if(is_string($comment)){
            $this->_comment=$comment;
        }
    }

    public function set_date_comment($date_comment){
        $this->_date_comment=new \DateTime($date_comment);
    }

    public function get_id(){
        return $this->_id;
    }

    public function get_id_user(){
        return $this->_id_user;
    }

    public function get_id_article(){
        return $this->_id_article;
    }

    public function get_id_parent(){
        return $this->_id_parent;
    }

    public function get_comment(){
        return $this->_comment;
    }

    public function get_date_comment(){
        return $this->_date_comment;
    }
}