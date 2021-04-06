<?php

namespace App\Router;

class Router{

    private $routes=[];
    private $url;

    public function __construct($url){
        $this->url=$url;
    }

    public function get($path,$action){
        $route=new Route($path,$action);
        $this->routes['GET'][]=$route;
    }

    public function post($path,$action){
        $route=new Route($path,$action);
        $this->routes['POST'][]=$route;
    }

    public function run(){
        foreach($this->routes[$_SERVER['REQUEST_METHOD']] as $route){
            
            if($route->match($this->url)){
                $route->execute();
            }
        }
    }
}