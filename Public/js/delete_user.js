jQuery(document).ready(function($){

    $("#delete_user").submit(function(e){
        e.preventDefault();

        if(confirm("Voulez-vous vraiment supprimer cet utilisateur")){

            loading_ajax();

            const url=$(this).attr("action");
            const method=$(this).attr("method");
            const formData=$(this).serialize();
 
            $.ajax({
                url: url,
                type: method,
                data:formData,
                dataType: "json"
            }).

            done(function(response){
                message_ajax(response);   
            }).

            fail(function(response){
                message_ajax(response.responseJSON);

                setTimeout(function(){
                    window.location.href=response.responseJSON.redirect;
                }, 2000);
            }).
            
            always(function(){
                $("#loading").remove();
                $("body").css("overflow","auto");
            })
        }
    })
})