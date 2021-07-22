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


    public function get_user($condition,$value){
      
        $this->prepare("SELECT * FROM users WHERE $condition = :value_condition");
        $this->execute_query_prepared(Array("value_condition" => $value));
        $result=$this->get_one();

        return $result;
    }

    public function get_user_email($email){
        
        $this->prepare("SELECT * FROM users WHERE email = :email");
        $this->execute_query_prepared(Array("email" => $email));
        $result=$this->get_one();

        return $result;

    }

    public function confirm_account($id){

        $this->prepare("UPDATE users SET account_confirmed=1 WHERE id =:id");

        $this->execute_query_prepared(Array("id" => $id));

    }

    public function update_user($champs,$new_value,$id){
        
        $this->prepare("UPDATE users SET $champs = :new_value WHERE id=:id");

        $this->execute_query_prepared(Array("id" => $id,
                                            "new_value" => $new_value));
    }

}