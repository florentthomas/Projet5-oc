jQuery(document).ready(function($){

    $("#new_password").keyup(safe_password);

    $("#reset_password").submit(function(e){

        e.preventDefault();

        const new_password=$("#new_password");
        const confirm_password=$("#confirm_password");
        const url=$(this).attr("action");
        const formData=$(this).serialize();

        if(new_password.val() === confirm_password.val()){

            if(password_conform){

                $.ajax({
                    url:url,
                    type:"POST",
                    data:formData,
                    dataType:"json"

                }).done(function(response){
                    message_ajax(response);
                    new_password.val("");
                    confirm_password.val("");
                })

                .fail(message_error_ajax)

            }

            else{
                message_error("Mot de passe pas assez fort");

            }
        }

        else
        {
            message_error("Les deux mots de passe ne sont pas identiques");
        }

        
    })




})