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


    public function create_account($pseudo,$email,$password,$key){

        $this->prepare("INSERT INTO users(pseudo,email,password_account,key_confirm) 
                        VALUES(:pseudo,:email,:password_account,:key_confirm)");

        $this->execute_query_prepared(Array("pseudo" => $pseudo,
                                            "email" => $email,
                                            "password_account" =>$password,
                                            "key_confirm" => $key));
    }

}