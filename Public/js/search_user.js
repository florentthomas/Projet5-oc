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
                    
                        const user=$("<div class='select_user' data-index='"+response.indexOf(response[i])+"' name='id_user' id='"+response[i].id+"'/><img class='photo_profil' src='"+ response[i].photo+"'/><span>"+response[i].pseudo+"</span></div>");
                        

                        user.appendTo("#search_result");
                    }


                    $(".select_user").click(function(){

                        $("#pseudo").html("");
                        $("#date_inscription").html("");
                        $("#type_user").html("");

                        $("#forms").css("display","block");

                        $("#search_user_input").val("");
                        
                        $('#search_result').css("display" ,"none");

                        const key_user_array=$(this).attr("data-index");

                        const user = response[key_user_array];
                        
                        $("#photo_user").attr("src",user.photo);
                        $("#pseudo").append(user.pseudo);
                        $("#date_inscription").append("Date d'inscrition: "+user.date_inscription);
                        $("#type_user").append("Type d'utilisateur: "+user.type_user);

                        $("input[type=hidden]").attr("value",user.id);

                        $("#user_info").css("display","block");

                    });
                }

                else{
                    $('#search_result').html("Aucun utilisateur");
                }
            })

            .fail(function(){
                message_error_ajax()
            })
            
        }

        else{
            $('#search_result').css("display" ,"none");
        }

        
    })


})