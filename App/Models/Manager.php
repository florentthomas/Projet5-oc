<?php

namespace App\Models;

abstract class Manager{


    protected function connect_bdd(){

        try{
            $bdd=new \PDO("mysql:host=localhost;dbname=projet_5_oc;charset=utf8","root","",
            array(\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_OBJ));
            
        }catch(\PDOException $e){
            echo $e->getMessage();
        }
        
        return $bdd;
    }

}