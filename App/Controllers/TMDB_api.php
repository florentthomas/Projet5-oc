<?php

namespace App\Controllers;


class TMDB_api extends Controller{

    private $key_api="70c27cbd777e852dea8ad394a6841c9b";
    private $url="https://api.themoviedb.org/3/search/";
    private $language="fr-FR";
    private $url_img_profile="https://www.themoviedb.org/t/p/w90_and_h90_face";
    
   

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


            $url=$this->url."multi?api_key=".$this->key_api."&language=".$this->language."&query=".$query."&page=1&include_adult=false";
          

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


}