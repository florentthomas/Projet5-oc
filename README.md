# Projet5-oc


## Projet 5 Openclassroom

![project-5](https://user-images.githubusercontent.com/40243927/208317892-01645b95-8ba6-473d-ae19-8031e0806d0a.PNG)


Réalisation d'un blog sur le cinéma


### Langages utilisés

* HTML
* CSS
* javaScript
* PHP


### Instructions à respecter pour ce projet


 #### Organiser le code en langage PHP

* Charger automatique des classes ou utilisation de l'autoload de Composer
* Séparer du code en respectant l'architecture MVC
* Utiliser des exceptions pour gérer les erreurs
* Utiliser des namespaces pour organiser les classes
* Créer des templates HTML avec syntaxe PHP alternative ou Twig


 #### Organiser et manipuler les données

* Créer et manipuler une session
* Valider des données côté serveur en PHP
* Valider des données côté client en JavaScript
* Créer de requêtes HTTP en JavaScript avec récupération de données en JSON (Ajax)
* Créer une pagination des données
* Envoyer des fichiers au serveur




 #### Sécuriser l'application

* Supprimer des injections XSS dans les données saisies puis réaffichées
* Supprimer des injections SQL avec PDO
* Créer de mots de passes sécurisés avec un hachage fiable
* Créer un système de login / logout



### Installation

Dans le dossier App, créer un dossier config et créer le fichier config.php avec le code suivant:

```
<?php
//PATH
define('PATH_VIEWS_FOLDER',str_replace('index.php','App/Views',$_SERVER['SCRIPT_FILENAME']));
define('PATH_ROOT',str_replace('index.php','',$_SERVER['SCRIPT_FILENAME']));
define('URL', str_replace('index.php', '', (isset($_SERVER['HTTPS']) ? 'https' : 'http').'://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']));
define('PATH_IMG_ARTICLE', str_replace('index.php','',$_SERVER['SCRIPT_FILENAME'].'Public/images/articles'));
define('PATH_IMG_AVATARS', str_replace('index.php','',$_SERVER['SCRIPT_FILENAME'].'Public/images/avatars'));
define('URL_IMG_ARTICLE', URL.'Public/images/articles/');
define('URL_IMG_AVATARS', URL.'Public/images/avatars/');
define('URL_IMG', URL.'Public/images/');

//Email
define('EMAIL', ''); //Saisir votre adresse email
define('EMAIL_PASSWORD', ''); //Votre mot de passe

//key api
define('KEY_TMDB_API', ''); //Votre clé API TMDB

//Config_db
define('HOST','');
define('USER','');
define('PASSWORD','');
define('DB_NAME','');
```
Utilisateur par défaut pour se connecter:
Email: mail@mail.fr
Mot de passe: Admin1234@!!!

