<?php

namespace App\Models;

class ArticleModel{

    private $_id,
            $_title,
            $_author,
            $_content,
            $_slug,
            $_date_create,
            $_date_update;

    public function set_id($id){
        if(is_numeric($id) && $id > 0){
            $this->_id=$id;
        }
    }

    public function set_title($title){
        if(is_string($title)){
            $this->_title=$title;
        }
    }

    public function set_author($author){
        if(is_string($author)){
            $this->_author=$author;
        }
    }

    public function set_content($content){
        if(is_string($content)){
            $this->_content=$content;
        }
    }

    public function set_slug($slug){
        if(is_string($slug)){
            $this->_slug=$slug;
        }
    }

    public function set_date_create($date_create){
        $this->_date_create=new \DateTime($date_create);
    }

    public function set_date_update($date_update){
        $this->_date_update=new \DateTime($date_update);
    }

    public function get_id(){
        return $this->_id;
    }

    public function get_title(){
        return $this->_title;
    }

    public function get_author(){
        return $this->_author;
    }

    public function get_content(){
        return $this->_content;
    }

    public function get_slug(){
        return $this->_slug;
    }

    public function get_date_create(){
        return $this->_date_create;
    }

    public function get_date_update(){
        return $this->_date_update;
    }
}