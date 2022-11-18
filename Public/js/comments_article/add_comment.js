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


                const comment=response.comment;
                const user = response.user;

                if(response.attribute == "success"){

                    // create card user

                    const cardUSer=createUserCard(user,comment);


                    //btn response, report and delete 

                    const btnDiv=$("<div></div>").addClass("btn_comment_end");

    
                    const form_report_comment=create_form_report_comment(comment);

                    const form_delete_comment=create_form_delete_comment(comment);


                    const menu_sandwich=$("<i></i>").addClass("fa-solid fa-list menu_comment");
                    
                    btnDiv.append(form_report_comment,form_delete_comment);
                 
                    
                

                    if(id_parent == 0){
                      

                         //button response

                        const btnEltReponse=$("<button></button>").addClass("btn_response button-blue").attr("data-id", comment.id).html("Répondre");
                        $(btnDiv).prepend(btnEltReponse);


                    
                        card_comment_parent=create_card_comment_parent(comment);

                        card_comment_parent.find(".container_comment").prepend(cardUSer)

                        const menu_sandwich=create_menu_hamburger();

                        card_comment_parent.append(menu_sandwich,btnDiv);

                        $("#comments_article").prepend(card_comment_parent);

                        
                    }

                    else{
                        const card_comment_child=create_card_comment_child(comment);
                      
                        card_comment_child.find(".container_comment").prepend(cardUSer);

                        const menu_sandwich=create_menu_hamburger();

                        $(card_comment_child).append(menu_sandwich,btnDiv);
                        
                        $("#comment-"+id_parent).after(card_comment_child);
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