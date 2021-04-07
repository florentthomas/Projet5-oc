<?php

namespace App\Views;


class View{

    public function generate_view($file,$data=[]){

        $loader = new FilesystemLoader(__DIR__.'/Views');
        $twig = new Environment($loader, [
            'cache' => false,
        ]);

        echo $twig->render($file.'.twig', $data);

    }
}