<?php

namespace App\Models;

abstract class Manager{

    private $_user;
    private $_host;
    private $_password;
    private $_db_name;
    private $_bdd;
    private $_query;


    public function __construct(){

        $this->_user=USER;
        $this->_host=HOST;
        $this->_password=PASSWORD;
        $this->_db_name=DB_NAME;
        
        try{
            $this->_bdd=new \PDO("mysql:host=".$this->_host.";dbname=".$this->_db_name.";charset=utf8",$this->_user,$this->_password,
            array(\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_OBJ));
            
        }catch(\PDOException $e){
            echo $e->getMessage();
        }
    }

    protected function query($sql){
        return $this->_query=$this->_bdd->query($sql);
    }

    protected function prepare($sql){
        $this->_query=$this->_bdd->prepare($sql);
    }

    protected function execute_query_prepared($data){
        $this->_query->execute($data);
    }

    protected function get_all(){
        return $this->_query->fetchAll();
    }

    protected function get_one(){
        return $this->_query->fetch();
    }

}