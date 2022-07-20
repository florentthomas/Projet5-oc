jQuery(document).ready(function($){


    $("#send_message").submit(function(e){
        e.preventDefault();

        loading_ajax();

        const url= $(this).attr("action");
        const method= $(this).attr("method");
        const id_user=$("#id_user").val();
        const subject=$("#subject").val();
        const message=CKEDITOR.instances['message_user'].getData();

        $.ajax({

            url:url,
            dataType:"JSON",
            type:method,
            data: {
                "id_user" : id_user,
                "message" : message,
                "subject" : subject
            }
        }).

        done(function(response){

            $("#subject").val("");
            CKEDITOR.instances["message_user"].setData('');
            message_ajax(response);
            
        }).

        fail(message_error_ajax).

        always(function(){
            $("#loading").remove();
            $("body").css("overflow","auto");
        })
    })


})