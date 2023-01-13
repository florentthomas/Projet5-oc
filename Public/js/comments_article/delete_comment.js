jQuery(document).ready(function($){


    $(document).delegate('.delete_comment','submit',function(e){

        e.preventDefault();

        const action=$(this).attr("action");

        const method=$(this).attr("method");

        const id_comment=$(this).find($("input[type=hidden]")).attr("value");

        const comment=$("#comment-"+id_comment);

        const formData=$(this).serialize();
        
        $.ajax({
            url: action,
            method: method,
            data: formData,
            dataType:"json"
        }).
        
        done(function(response){

            message_ajax(response);

            if(response.attribute == "success"){
                comment.fadeOut();
            
                let responses= $("[data-parent-id="+id_comment+"]");

                responses.fadeOut();

            }

            
           
        }).

        fail(message_error_ajax)
    
    })
})