jQuery(document).ready(function($){

    //Changement pseudo

    $("#form_pseudo").submit(function(e){

        e.preventDefault();

        const url=$(this).attr("action");
        const formData=$(this).serialize();

        $.ajax({
            url: url,
            type: "POST",
            data:formData

        }).done(function(response){

            message_ajax(response);
            $("#pseudo").val("");
 
        }).fail(message_error_ajax);

    })


  //Changement email

    $("#form_email").submit(function(e){

        e.preventDefault();

        const url=$(this).attr("action");
        const formData=$(this).serialize();

        const new_email=$("#email").val();
        const confirm_email=$("#email_confirm").val();

        if(new_email === confirm_email){

            loading_ajax();
            
            $.ajax({
                url: url,
                type: "POST",
                data:formData
    
            }).done(function(response){

                message_ajax(response);
                
                $("#email").val("");
                $("#email_confirm").val("");
     
            }).fail(message_error_ajax)
            
            .always(function(){
                $("#loading").remove();
                $("body").css("overflow","auto");
            });

        }
        
        else{
            message_error("Les adresses ne sont pas identiques");
        }
    })



    //Changement mot de passse

    $("#new_password").keyup(safe_password);

    $("#form_password").submit(function(e){

        e.preventDefault();

        const url=$(this).attr("action");
        const formData=$(this).serialize();

        const current_password=$("#current_password").val();
        const new_password=$("#new_password").val();
        const confirm_password=$("#confirm_new_password").val();
        
        
        if(new_password === confirm_password){
            $.ajax({
                url:url,
                type:"POST",
                data:formData
            }).done(function(response){

                message_ajax(response);

                if(data.attribute === "success"){
                    $("#form_password").find("input").val("");
                }
                
            }).fail(message_error_ajax)

        }

        else if(password_conform !== true){
            message_error("Le mot de passe n'est pas assez sécurisé");
        }

        else{
            message_error("Les mots de passe ne sont pas identiques");
        }
    })


    //suppression du compte

    $("#form_delete_account").submit(function(e){

        e.preventDefault();

        const url=$(this).attr("action");
        
        loading_ajax();
        
        $.ajax({
            url: url,
            type: "GET",

        }).done(message_ajax)
        
        .fail(message_error_ajax)
        
        .always(function(){

            $("#loading").remove();
            $("body").css("overflow","auto");
        });

    })

    //photo de profil

    $('#photo_profil').submit(function(e){
        e.preventDefault();

        const url=$(this).attr("action");
        const dataForm=new FormData(this);


        $.ajax({
            url:url,
            type:"POST",
            processData: false, 
            contentType: false,
            data:dataForm

        }).done(message_ajax)

        .fail(message_error_ajax)
    })
})