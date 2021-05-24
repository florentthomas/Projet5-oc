<?php

namespace App\Models;

abstract class Manager{

    private $_user;
    private $_host;
    private $_password;
    private $_db_name;

    public function __construct(){
        $this->_user=USER;
        $this->_host=HOST;
        $this->_password=PASSWORD;
        $this->_db_name=DB_NAME;
    }


    protected function connect_bdd(){

        try{
            $bdd=new \PDO("mysql:host=".$this->_host.";dbname=".$this->_db_name.";charset=utf8",$this->_user,$this->_password,
            array(\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_OBJ));
            
        }catch(\PDOException $e){
            echo $e->getMessage();
        }
        
        return $bdd;
    }

}