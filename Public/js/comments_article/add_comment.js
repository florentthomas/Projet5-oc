jQuery(document).ready(function($){

    $("#form_comment").submit(function(e){

        e.preventDefault();

        const url=$(this).attr("action");
        const formData=$(this).serialize();
        const id_parent=$(this).find("#id_parent").val();

        $.ajax({
            url: url,
            type: "POST",
            data:formData,
            dataType: "json"

        })
        
            .done(function(response){


                const comment=response.comment
                const current_user=response.current_user
                const account_confirmed=true

                if(response.attribute == "success"){

                    if(comment.id_parent == 0){
                        $("#comments_article").prepend(comment_parent_template(comment,account_confirmed,current_user))
                    }

                    else if (comment.id_parent > 0) {
                        $("#comment-"+comment.id_parent).after(comment_child_template(comment,account_confirmed,current_user))
                    }

                    

                    $("#comment_area").val("");
                    $("#form_comment_article").append($("#form_comment"));
                    $("#id_parent").attr("value", 0);
                    $("#comment_area").attr("placeholder", "Ecrivez un commentaire");
                    message_ajax(response);
                    
                }

                else{
                    message_ajax(response);
                }

            })
            
            .fail(message_error_ajax);

    })

})