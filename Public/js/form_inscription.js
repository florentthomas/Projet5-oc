jQuery(document).ready(function($){

    $("#password_1").keyup(safe_password);

    $("#form_inscription").submit(function(e){
        e.preventDefault();
        

        const password_1=$("#password_1").val();
        const password_2=$("#password_2").val();
        const message_password=$("#message_password");

        if(password_1 === password_2){

            if(password_conform){

                const url=$(this).attr("action");
                const formData=$(this).serialize();

                $.ajax({
                    url: url,
                    type: "POST",
                    data:formData,
                    dataType:"json"
                }).done(function(response){
                    

                    message_ajax(response);

                    $("input","#form_inscription").val('');
                    
                }).fail(message_error_ajax);

            }
            else{
                message_error("Le mot de passe n'est pas assez fort");
            }
    
        }

        else{
            message_error("Les mots de passe ne sont pas identiques");
        }
        
    });

});