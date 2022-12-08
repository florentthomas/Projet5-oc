<?php

namespace App\Controllers;

use Twig\Extra\Markdown\MarkdownExtension;
use Twig\Extra\Markdown\DefaultMarkdown;
use Twig\Extra\Markdown\MarkdownRuntime;
use Twig\RuntimeLoader\RuntimeLoaderInterface;
use Twig\Extra\String\StringExtension;
use Twig\Extra\Intl\IntlExtension;




abstract class Controller{

    public function view($file,$data=[]){

        $loader = new \Twig\Loader\FilesystemLoader(PATH_VIEWS_FOLDER);

        

        $twig = new \Twig\Environment($loader, [
            'cache' => false,
            'debug' => true,
        ]);
        
       
        $twig->addExtension(new \Twig\Extension\DebugExtension());


        $twig->addExtension(new MarkdownExtension());

        

        $twig->addRuntimeLoader(new class implements RuntimeLoaderInterface {
            public function load($class) {
                if (MarkdownRuntime::class === $class) {
                    return new MarkdownRuntime(new DefaultMarkdown());
                }
            }
        });

        $twig->addExtension(new StringExtension());

        $twig->addExtension(new IntlExtension());
        
        $twig->addGlobal("URL",URL);
        $twig->addGlobal("session", $_SESSION);
        $twig->addGlobal("URL_IMG_ARTICLE", URL_IMG_ARTICLE);
        $twig->addGlobal("URL_IMG_AVATARS", URL_IMG_AVATARS);
        $twig->addGlobal("URL_IMG", URL_IMG);

            
        echo $twig->render($file.".twig", $data);
    }

    public function model($model){

        $class="App\\Models\\".$model;
        return new $class();
    }


}