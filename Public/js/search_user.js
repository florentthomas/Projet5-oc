jQuery(document).ready(function($){



    $("#search_user_input").keyup(function(){

        const url=$(this).attr("data-search-url");

    
        if($(this).val() != ""){

            

            $.ajax({
                data:"user="+encodeURIComponent($(this).val()),
                dataType: "json",
                type: "GET",
                url: url

            }).

            done(function(response){

                $('#search_result').html("");
                $('#search_result').css("display" ,"block");



                if(response != ""){

                    for(let i = 0; i < response.length; i++){
                    
                        const user=$("<div class='select_user' name='id_user' id='user_"+response[i].id+"'/><img class='photo_profil' src='"+ response[i].url_photo+"'/><span>"+response[i].pseudo+"</span></div>");


                        user.appendTo("#search_result");
                    }
                }

                else{
                    $('#search_result').html("Aucun utilisateur");
                }
            })

            .fail(function(){
                console.log("error");
            })
            
        }

        else{
            $('#search_result').css("display" ,"none");
        }

        
    })


})