<?php


namespace App\Models;


class UserManager extends Manager{


    public function email_exists($email){

        $this->prepare("SELECT * FROM users WHERE email =:email");
        $this->execute_query_prepared(["email" => $email]);
        $result=$this->get_one();

        return $result;

    }

    public function pseudo_exists($pseudo){

        $this->prepare("SELECT * FROM users WHERE pseudo =:pseudo");
        $this->execute_query_prepared(["pseudo" => $pseudo]);
        $result=$this->get_one();

        return $result;

    }

}