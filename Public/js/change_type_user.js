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

                const new_type_user=$("#form_select_type").find("option:selected").attr("value");
                $("#type_user").text(new_type_user);
              
            })
            
            .fail(message_error_ajax)
    })


})