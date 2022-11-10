jQuery(document).ready(function($){




    $(document).delegate(".report_comment","submit",function(e){

        e.preventDefault();

        const comment_id=$(this).data("id");
        const url=$(this).attr("action");
        const fomrData=$(this).serialize();
        
       
        $.ajax({
            url: url,
            type: "POST",
            data:fomrData,
            dataType: "json"
            

        }).
        done(function(response){
            message_ajax(response);
        }).
        fail(message_error_ajax)
    
    })


})