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

                
                if(response.attribute == "success"){

                    // create card comment

            
                    let containerComment=$("<div></div>").addClass("container_comment");
                    
                    let commentDiv=$("<div></div>").addClass("comment").html(response.comment);

                    //card user

                    let userDiv=$("<div></div>");
                    userDiv.addClass("user");

                    let photoUser=$("<img/>").addClass("photo_profil");
                    let pseudoDiv=$("<div></div>");
                    let dateCommentDiv=$("<div></div>");


                    photoUser.attr("src", response.photo);
                    pseudoDiv.html(response.pseudo);
                    dateCommentDiv.html(response.date);

                    $(userDiv).append(photoUser);
                    $(userDiv).append(pseudoDiv);
                    $(userDiv).append(dateCommentDiv);

                    //btn response, report and delete 

                    const btnDiv=$("<div></div>").addClass("btn_comment_end");

                    const formElt=$("<form></form>").addClass("report_comment");
                    const report_url=$(".report_comment").attr("action");
                    formElt.attr({"action": window.location.origin+"/projet-5/blog/report_comment", "method":"post", "data-id":response.id_comment});

                    
                    const btnReport=$("<button></button>").addClass("button-red").html("Signaler");

                    const formDeleteComment=$("<form></form>").addClass("delete_comment").attr({"action": window.location.origin+"/projet-5/blog/delete_comment", "method":"post"});
                    
                    const btnDelete=$("<button></button>").addClass("button-red").html("Supprimer");

                    const inputElt=$("<input/>").attr({"type" : "hidden", "value" : response.id_comment, "name" : "comment_id"});
                    

                    formDeleteComment.append(btnDelete);
                    formDeleteComment.append(inputElt);
                    

                    
                    if(id_parent == 0){
                        
                        //button response
                        const btnEltReponse=$("<button></button>").addClass("btn_response button-blue").attr("data-id", response.id_comment).html("Répondre");
                        $(btnDiv).append(btnEltReponse);
                    }
                    

                
                    
                    $(formElt).append(btnReport);
                    $(containerComment).append(userDiv);
                    $(btnDiv).append(formElt);
                    $(btnDiv).append(formDeleteComment);
                   

                    $(containerComment).append(commentDiv);
                

                    if(id_parent == 0){
                        let cardElt=$("<div></div>").addClass("comment_article_card").attr("id", "comment-"+response.id_comment);
                        $(cardElt).append(btnDiv);
                        cardElt.prepend(containerComment);
                        $("#comments_article").prepend(cardElt);
                    }

                    else{
                        let cardEltChildren=$("<div></div>").addClass("response_comment_card").attr({"id": "comment-"+response.id_comment , "data-id-parent": id_parent});
                        $(cardEltChildren).append(btnDiv);
                        cardEltChildren.prepend(containerComment);
                        $("#comment-"+id_parent).after(cardEltChildren);
                    }


                    $("#comment_area").val("");
                    message_ajax(response);
                    
                }

                else{
                    message_ajax(response);
                }

            })
            
            .fail(message_error_ajax);

    })

})