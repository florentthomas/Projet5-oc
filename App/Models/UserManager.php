<?php


namespace App\Models;


class UserManager extends Manager{


    public function email_exists($email){

        $sth=$this->bdd->prepare("SELECT * FROM users WHERE email =:email");
        $sth->execute(Array("email" => $email));
        $result=$sth->fetch();

        return $result;

    }

    public function pseudo_exists($pseudo){

        $sth=$this->bdd->prepare("SELECT * FROM users WHERE pseudo =:pseudo");
        $sth->execute(Array("pseudo" => $pseudo));
        $result=$sth->fetch();

        return $result;

    }


    public function create_account($pseudo,$email,$password,$key,$photo){

        $sth=$this->bdd->prepare("INSERT INTO users(pseudo,email,password_account,key_confirm,photo) 
                        VALUES(:pseudo,:email,:password_account,:key_confirm,:photo)");

       

        $sth->execute(Array("pseudo" => $pseudo,
                            "email" => $email,
                            "password_account" =>$password,
                            "key_confirm" => $key,
                            "photo" => $photo));
    }


    public function get_user($condition,$value){

        $sth=$this->bdd->prepare("SELECT * FROM users WHERE $condition = :value_condition");
        $sth->execute(Array("value_condition" => $value));
        $result=$sth->fetch();
   
        return $result;
    }

    public function search($value_input){

        $value_input=$value_input."%";

        $sth=$this->bdd->prepare("SELECT id,pseudo,photo,type_user,date_inscription FROM users WHERE pseudo LIKE :value_input LIMIT 15");
        $sth->execute(Array("value_input" => $value_input));
        $result=$sth->fetchAll();

        return $result;
    }

    public function get_user_email($email){
        
        $sth=$this->bdd->prepare("SELECT * FROM users WHERE email = :email");
        $sth->execute(Array("email" => $email));
        $result=$sth->fetch();

        return $result;

    }

    public function confirm_account($id){

        $sth=$this->bdd->prepare("UPDATE users SET account_confirmed=1 WHERE id =:id");

        $sth->execute(Array("id" => $id));

    }

    public function update_user($champs,$new_value,$id){

        $sth=$this->bdd->prepare("UPDATE users SET $champs = :new_value WHERE id=:id");

        $sth->execute(Array("id" => $id,
                            "new_value" => $new_value));
    
        $count=$sth->rowCount();

        if($count >= 1){
            return true;
        }

        else{
            return false;
        }

    }


    public function delete_account($id){
        
        $sth=$this->bdd->prepare("DELETE FROM users WHERE id=:id");
        $sth->execute(Array("id" => $id));

        return $sth->rowCount();
    }

}