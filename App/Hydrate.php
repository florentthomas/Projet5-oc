<?php

namespace App\Models;

trait Hydrate
{
    public function hydrate($data){
        foreach($data as $key => $value){
            $method="set_".$key;

            if(method_exists($this,$method)){
                $this->$method($value);
            }
        }
    }
}
