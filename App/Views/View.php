<?php

namespace App\Views;


class View{

    public function generate_view($file,$data=[]){

        $loader = new \Twig\Loader\FilesystemLoader(__DIR__);

        $twig = new \Twig\Environment($loader, [
            'cache' => false,
        ]);

        echo $twig->render($file.'.twig', $data);

    }
}