jQuery(document).ready(function($){


    $(document).delegate('.delete_comment','submit',function(e){

        e.preventDefault();

        const action=$(this).attr("action");

        const method=$(this).attr("method");

        const id_comment=$(this).find($("input[type=hidden]")).attr("value");

        console.log(id_comment);

        const comment=$("#comment-"+id_comment);
        

        $.ajax({
            url: action,
            method: method,
            data: {"id_comment" : id_comment},
            dataType:"json"
        }).
        
        done(function(response){

            message_ajax(response);

            if(response.attribute == "success"){
                comment.fadeOut();
            
                let responses= $("[data-id-parent="+id_comment+"]");

                console.log(responses);

                responses.fadeOut();

            }

            
           
        }).

        fail(message_error_ajax)
    
    })
})