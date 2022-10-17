jQuery(document).ready(function($){





    $("#delete_article").submit(function(e){

        e.preventDefault();
        
        if(confirm("Voulez-vous vraiment supprimer cet article définitivement?")){

           
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

                setTimeout(function(){
                    window.location.href=response.redirect;
                }, 2000);
            }).

            fail(function(response){
                message_ajax(response.responseJSON);

                setTimeout(function(){
                    window.location.href=response.responseJSON.redirect;
                }, 2000);
            })
    
    
        }    
    })
})