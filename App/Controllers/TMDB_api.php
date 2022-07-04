<?php

namespace App\Controllers;


class TMDB_api extends Controller{

    private $key_api="70c27cbd777e852dea8ad394a6841c9b";
    private $url="https://api.themoviedb.org/3/";
    private $language="fr-FR";
    private $url_img_profile="https://www.themoviedb.org/t/p/w90_and_h90_face";
    private $url_image="https://image.tmdb.org/t/p/original";
    
   

    private function request_api($url){
        
        
        $curl=curl_init($url);

        curl_setopt_array($curl,Array(
            // CURLOPT_CAINFO => PATH_ROOT."cert.cer",
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CONNECTTIMEOUT => 1
        ));
        

            $data= curl_exec($curl);


            if($data != false){

                
                if(curl_getinfo($curl, CURLINFO_HTTP_CODE) === 200){

                    $data= json_decode($data);

                    return $data;

                }
                else{
                    http_response_code(404);
                    $this->view("404");
                }
            }

            curl_close($curl);
    }



    public function search(){


        if(isset($_GET["query"]) && !empty($_GET["query"])){

            
            $query=str_replace(" ", "+",$_GET["query"]);


            $url=$this->url."search/multi?api_key=".$this->key_api."&language=".$this->language."&query=".$query."&page=1&include_adult=false";
          

            $results=$this->request_api($url);

            $data=[];


            if($results !== null){
                

                foreach($results->results as $item){

                   

                    $movies=[];

                    if($item->media_type === "person"){

                        if($item->profile_path == ""){
                            $image_profile= URL_IMG_AVATARS."default.png";
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

                        $data["movies"][]=[
                            "id" => $item->id,
                            "title" => $item->title,
                            "media_type" => $item->media_type,
                            "image_profile" => $this->url_img_profile."".$item->poster_path,
                            "overview" => $item->overview,
                            "date" => $item->release_date
                        ];

                    }
                    
                }

                $this->view("result_search", Array("data" => $data));

            }   


        }
        else{
            header("Location:".URL);
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
            }

            $data["teaser"]=$teaser;
        }

    

        $runtime= $result_movie_info->runtime;

        if($runtime === 0 || $runtime === null){
            $time_movie="Durée du film inconnue";
        }
        else{
            $time_hour=explode(".",$runtime / 60);
            $time_minute="0.".$time_hour[1];

            $time_movie=$time_hour[0]."h".ceil($time_minute*60)."min";
        }

        



        if($result_movie_info->poster_path === "" || $result_movie_info->poster_path === null ){
            $poster=URL_IMG."no-image.png";
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


}

