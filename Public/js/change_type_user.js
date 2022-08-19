jQuery(document).ready(function($){



    $("#form_type_user").submit(function(e){

        e.preventDefault();

        const url=$(this).attr("action");
        const formData=$(this).serialize();
        const method=$(this).attr("method");

        $.ajax({
            url:url,
            dataType:"JSON",
            type:method,
            data: formData
            
        }).

            done(function(response){
                
                message_ajax(response);

                const new_type_user=$("#form_type_user").find("input:checked").attr("value");
                $("#type_user").text("Type d'utilisateur: "+new_type_user);
              
            }).
            
            fail(function(response){
                
                message_ajax(response.responseJSON);

                setTimeout(function(){
                    window.location.href=response.responseJSON.redirect;
                  }, 2000);
            })
    })


})