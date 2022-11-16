jQuery(document).ready(function($){


    $("#send_message").submit(function(e){
        e.preventDefault();

        loading_ajax();

        const url= $(this).attr("action");
        const method= $(this).attr("method");
        const dataForm=$(this).serialize();

        

        $.ajax({

            url:url,
            dataType:"JSON",
            type:method,
            data: dataForm
        }).

        done(function(response){

            $("#subject").val("");
            $("#message_user").summernote('reset')
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
    })


})