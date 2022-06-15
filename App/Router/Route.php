<?php

namespace App\Router;

class Route{

    private $path;
    private $action;
    private $params;

    public function __construct($path,$action){
        $this->path=trim($path,"/");
        $this->action=$action;
        $this->params=[];
    }

    public function match($url){

        $url=trim($url,"/");

        $pathPattern=preg_replace("#:([\w]+)#","([^/]+)",$this->path);

        $regex="#^$pathPattern$#i";


        if(!preg_match($regex,$url,$this->params)){
            return false;
        }
     
        return true;

    }

    public function execute(){

        $action=explode('@',$this->action);
        $controller="App\\Controllers\\".$action[0];
        $method=$action[1];
        
        try{
            if(class_exists($controller)){
                if(method_exists($controller,$method)){
                    $controller=new $controller();

                    if($_SERVER["REQUEST_METHOD"] === "GET"){
                        return isset($this->params) ? $controller->$method($this->params) : $controller->$method();
                    }

                    if($_SERVER["REQUEST_METHOD"] === "POST"){
                        return isset($_POST) ? $controller->$method($_POST) : $controller->$method();
                    }
                }
            }else{
                
                throw new \Exception("Error Processing Request", 1);
                
            }

        }
        catch(\Exception $e){
           echo $e->getMessage();
        }

        
    }
}