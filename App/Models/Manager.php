<?php

namespace App\Models;

abstract class Manager{


    private function connect_bdd(){

        $bdd=new \PDO("mysql:host=localhost;dbname:projet_5_oc;charset=utf8","root";"");
        array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        return $bdd;
    }

}