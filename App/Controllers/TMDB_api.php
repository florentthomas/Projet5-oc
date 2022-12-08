<?php

namespace App\Controllers;


class TMDB_api extends Controller{
  
    private $key_api=KEY_TMDB_API;
    private $url="https://api.themoviedb.org/3/";
    private $language="fr-FR";
    private $url_img_profile="https://www.themoviedb.org/t/p/w90_and_h90_face";
    private $url_image="https://image.tmdb.org/t/p/original";
    
   

    private function request_api($url){
        
        $curl=curl_init($url);

        curl_setopt_array($curl,Array(
            CURLOPT_CAINFO => PATH_ROOT."cert.cer",
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CONNECTTIMEOUT => 1
        ));
        

            $data= curl_exec($curl);

            

            try{

               

                if($data === false){

                    $error=curl_error($curl);
                    http_response_code(404);
                    throw new \Exception($error);
                    
    
                }
    
           
                if(curl_getinfo($curl, CURLINFO_HTTP_CODE) !== 200){
    
                    $data= json_decode($data);
                
    
                    if(curl_getinfo($curl, CURLINFO_HTTP_CODE) === 401){
                        http_response_code(401);
                        throw new \exception($data->status_message);
                    }
    
                    
                    else{
                        http_response_code(curl_getinfo($curl, CURLINFO_HTTP_CODE));
                        throw new \exception($data->status_message);
                        
                    }
    
                }
    
                if(curl_getinfo($curl, CURLINFO_HTTP_CODE) === 200){
    
                    $data= json_decode($data);
    
                    return $data;
    
                }

            }

            catch(\Exception $e){
            
                $message=$e->getMessage();
                $this->view("404",array("message_exception" => $message));
                die();
                
            }

            
            
            
           
            
            curl_close($curl);
    }



    public function search(){


        if(isset($_GET["query"]) && !empty($_GET["query"])){

            
            $query=str_replace(" ", "+",$_GET["query"]);


            $url=$this->url."search/multi?api_key=".$this->key_api."&language=".$this->language."&query=".$query."&page=1&include_adult=false";
          
  
            $results=$this->request_api($url);
         
           
            

            $data=[];

        

            if($results->total_results >= 1){
                

                foreach($results->results as $item){

                   

                    $movies=[];

                    if($item->media_type === "person"){

                        if($item->profile_path == ""){
                            $image_profile= URL_IMG_AVATARS."default.svg";
                        }
                        else{
                            $image_profile= $this->url_img_profile."".$item->profile_path;
                        }

                        if(property_exists($item, "known_for")){

                            foreach($item->known_for as $movie){

                                if(property_exists($movie, "original_title")){
                                    $movies[]=$movie->original_title;
                                }
                                else{
                                    $movies[]=$movie->original_name;
                                }

                            }

                        }
               
                        $data["person"][]=[
                            "id" => $item->id,
                            "name" => $item->name,
                            "media_type" => $item->media_type,
                            "image_profile" => $image_profile,
                            "movie" => $movies
                        ];
      
                    }

                    

                    if($item->media_type === "movie"){

                        if($item->poster_path === "" || $item->poster_path === null){
                            $poster=URL_IMG."no_image.svg";
                        }
                        else{
                            $poster=$this->url_img_profile."".$item->poster_path;
                        }

                        $data["movies"][]=[
                            "id" => $item->id,
                            "title" => $item->title,
                            "media_type" => $item->media_type,
                            "image_profile" => $poster,
                            "overview" => $item->overview,
                            "date" => $item->release_date
                        ];

                    }
                    
                }

                

            }
        

            $this->view("result_search", Array("data" => $data));


        }
        else{
            http_response_code(404);
            $this->view("404",array());
        }
    }


    public function get_movie($params){


        $id_movie=(int)$params[1];

        $url_movie_info=$this->url."movie/".$id_movie."?api_key=".$this->key_api."&language=".$this->language;
        $url_movie_credit=$this->url."movie/".$id_movie."/credits?api_key=".$this->key_api."&language=".$this->language;
        $url_movie_teaser=$this->url."movie/".$id_movie."/videos?api_key=".$this->key_api."&language=".$this->language;


        $result_movie_info=$this->request_api($url_movie_info);
        $result_movie_credit=$this->request_api($url_movie_credit);
        $result_movie_teaser=$this->request_api($url_movie_teaser);
    
            
      


        if(empty($result_movie_teaser->results)){
            $data["teaser"]=null;
            
        }
        else{
            foreach($result_movie_teaser->results as $video){
                
                if($video->type === "Trailer"){
                    $teaser=$video;
                    break;
                }

                if($video->type === "Clip"){
                    $teaser=$video;
                    break;
                }
            }

            $data["teaser"]=$teaser;
        }

        

        $runtime= $result_movie_info->runtime;

        if($runtime === 0 || $runtime === null){
            $time_movie="Durée du film inconnue";
        }
        else{
            $time_hour=explode(".",$runtime / 60);

            if(isset($time_hour[1])){
                $time_minute="0.".$time_hour[1];
                $time_movie=$time_hour[0]."h".ceil($time_minute*60)."min";
            }

            else{
                $time_movie=$time_hour[0]."h";
            }
            
            
            
        }

        



        if($result_movie_info->poster_path === "" || $result_movie_info->poster_path === null ){
            $poster=URL_IMG."no_image.svg";
        }else{
            $poster=$this->url_image."".$result_movie_info->poster_path;
        }


        if($result_movie_info->budget === 0 || $result_movie_info->budget === null ){
            $budget="Non communiqué";
        }else{
            $budget=$result_movie_info->budget."$";

            
        }


        if(!empty($result_movie_info->production_countries)){
            $country=$result_movie_info->production_countries[0]->iso_3166_1;
        }else{
            $country="Non communiqué";
        }



        $data["info_movie"]=[
            "title" => $result_movie_info->original_title,
            "date" => $result_movie_info->release_date,
            "time" =>$time_movie,
            "backdrop_path" => $this->url_image."".$result_movie_info->backdrop_path,
            "budget" => $budget,
            "genres" => $result_movie_info->genres,
            "overview" => $result_movie_info->overview,
            "poster" => $poster,
            "production_compagnies" => $result_movie_info->production_companies,
            "production_country" => $country
        ];





        for ($i=0; $i < count($result_movie_credit->cast) ; $i++) {

            if($result_movie_credit->cast[$i]->profile_path === null){
                $result_movie_credit->cast[$i]->profile_path=URL_IMG_AVATARS."default.svg";
            }
            else{
                $result_movie_credit->cast[$i]->profile_path=$this->url_image."".$result_movie_credit->cast[$i]->profile_path;   
            }
            
            $data["casting"]["actors"][]=$result_movie_credit->cast[$i];

            if($i === 9){
                break;
            }
        }




        foreach($result_movie_credit->crew as $person){

            if($person->job === "Director"){

                if($person->profile_path === null){
                    $person->profile_path=URL_IMG_AVATARS."default.svg";
                }
                else{
                    $person->profile_path=$this->url_image."".$person->profile_path;
                }
                
                $data["casting"]["director"]=$person;
            }

        }

        $this->view("result_movie_api", Array("data"=>$data));
        
            
       
    }

    public function get_person($params){

        
        $id_person=(int)$params[1];
        

        $url_person_info=$this->url."person/".$id_person."?api_key=".$this->key_api."&language=".$this->language;
        $url_person_movies=$this->url."person/".$id_person."/movie_credits?api_key=".$this->key_api."&language=".$this->language;


    
        $result_person_info=$this->request_api($url_person_info);
        $result_person_movies=$this->request_api($url_person_movies);

        

   
     
        


        if($result_person_info->profile_path === null || $result_person_info->profile_path === ""){
            $profile_path=URL_IMG_AVATARS."default.svg";
        }
        else{
            $profile_path=$this->url_image."".$result_person_info->profile_path;
        }


        $birthday= $result_person_info->birthday ? : "Non communiqué";
        $job= $result_person_info->known_for_department ? : "Non communiqué";
        $place_of_birth= $result_person_info->place_of_birth ? : "Non communiqué";
        $job= $result_person_info->known_for_department ? : "Non communiqué";
        $biography= $result_person_info->biography ?  : "Aucune biographie pour ".$result_person_info->name;
        $gender= $result_person_info->gender === 2 ? "male" : "female"; 
        
        

        $data["info_person"]=[
            "name"=> $result_person_info->name,
            "job" => $job,
            "place_of_birth" => $place_of_birth,
            "profile_path" => $profile_path,
            "deathday" => $result_person_info->deathday,
            "birthday" => $result_person_info->birthday,
            "biography" => $biography,
            "gender" => $gender
        ];


        function date_compare($a, $b){
            $t1 = strtotime($a->release_date);
            $t2 = strtotime($b->release_date);
            return $t1 - $t2;
        }  


        //recupere les films selon le poste occupé et trie par date  
        foreach($result_person_movies->crew as $movie){

            if($movie->job === "Director"){

                $data["movies"]["director"][]=$movie;
                usort($data["movies"]["director"], 'App\Controllers\date_compare');
             
            }

            if($movie->job === "Executive Producer" || $movie->job === "Producer" ){
                $data["movies"]["production"][]=$movie;
                usort($data["movies"]["production"], 'App\Controllers\date_compare');

            }
        }

        foreach($result_person_movies->cast as $movie){
           
            if($movie->character === "Self" || $movie->character === "Himself" || $movie->character === "Herself" ){

                if($data["info_person"]["gender"] === "male"){
                    $movie->character="Lui-même";
                }
                else{
                    $movie->character="Elle-même";
                }
                
            }
            $data["movies"]["acting"][]=$movie;
            usort($data["movies"]["acting"], 'App\Controllers\date_compare');
        }




        if(array_key_exists("movies", $data) && $data["movies"] !== null){

            //trie tous les films du tableau par ordre de popularité

            $extract= function($obj){
                return $obj->id;
            };

            $movies_popular = array();
            $all_movies= array();
           
            foreach($data["movies"] as $key => $movies){

        
                foreach($movies as $sub_key => $sub_movies){
                   
                 
                    $id_movie=$sub_movies->id;

                    //Supprime les doublons
                   
                    if(in_array($id_movie, array_map($extract,$all_movies)) === false){

                        
                        $all_movies[]=$sub_movies;
                    }
      
                    
                }

            }

            foreach($all_movies as $movie){
                $movies_popular[] = $movie->vote_count;
            }


            array_multisort($movies_popular, SORT_DESC, $all_movies);
         
            //recuperation des 10 films les plus populaires

            for($i=0; $i < count($all_movies); $i++){
    
                if($all_movies[$i]->poster_path === null || $all_movies[$i]->poster_path === "" ){
                    $all_movies[$i]->poster_path= URL_IMG."no_image.svg";
                }
                else{
                    $all_movies[$i]->poster_path=$this->url_image."".$all_movies[$i]->poster_path;
                }
    
                $data["popular_movies"][]=$all_movies[$i];
            
                if($i == 9){
                    break;
                }
    
            }

           

        }
        

        
        $this->view("result_person_api", Array("data" => $data));

    }

}

