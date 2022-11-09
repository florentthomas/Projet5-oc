jQuery(document).ready(function($){


let current_page=1;

const url_current = window.location.href;

const id_article = url_current.split("-").pop();

const split_url = url_current.match(/(.+)\/(.+)/);

const url_request=split_url[1]+"/get_comments";

const loadCommentsMsg=$("#load_comments_msg");



$(window).scroll(function() {

    if($(window).scrollTop() == $(document).height() - $(window).height()) {

        current_page++;

        loadCommentsMsg.text("Chargement des commentaires");

        $("#comments_article").append(loadCommentsMsg);

        $.ajax({
            url: url_request,
            type: "POST",
            data: {
                id_article: id_article,
                current_page: current_page
            },
            dataType: "json"
        }).

        

        done(function(response){

            loadCommentsMsg.text("");

            comments=response.comments;

            users= response.users;

            account_confirmed=response.account_confirmed;

            current_user=response.current_user;

            
            if(comments != undefined){

                comments.forEach(commentElt => {

         
                    //Create div element and insert comments

                    let cardElt=$("<div></div>").addClass("comment_article_card").attr("id", "comment-"+commentElt.id);
                 
                    let containerComment=$("<div></div>").addClass("container_comment");
                    

                    let commentDiv=$("<div></div>").addClass("comment").html(commentElt.comment);
                 

                    users.forEach(user =>{

                        if(user.id == commentElt.id_user){
                            let userDiv=createUserCard(user,commentElt);
                            $(containerComment).append(userDiv);
                        }
                    })


                    if(account_confirmed != false){

                       //insert buttons response and report comment if user's account is valid

                        const btnDiv=$("<div></div>").addClass("btn_comment_end");
                    

                        //button response
                        const btnEltReponse=$("<button></button>").addClass("btn_response button-blue").attr("data-id", commentElt.id).html("Répondre");
                      
            
                        
                     

                        //form report comment
                        const formElt=$("<form></form>").addClass("report_comment");

                        const report_url=$(".report_comment").attr("action");
                
                        formElt.attr({"action": report_url, "method":"post", "data-id":commentElt.id});
                       
                        const btnReport=$("<button></button>").addClass("button-red").html("Signaler");


                        $(formElt).append(btnReport);
                        $(btnDiv).append(btnEltReponse);
                        $(btnDiv).append(formElt);
                        
                        $(cardElt).append(btnDiv);



                        //button delete comment

                        if(current_user == commentElt.id_user){
                            
                            const formDeleteComment=$("<form></form>").addClass("delete_comment").attr({"action": window.location.origin+"/projet-5/blog/delete_comment", "method":"post"});

                            const btnDelete=$("<button></button>").addClass("button-red").html("Supprimer");

                            const inputElt=$("<input/>").attr({"type" : "hidden", "value" : commentElt.id, "name" : "comment_id"});

                            $(formDeleteComment).append(btnDelete);
                            $(formDeleteComment).append(inputElt);
                            $(btnDiv).append(formDeleteComment);

                        }
                       
                        
                    }

                   
                    $(containerComment).append(commentDiv);
                    cardElt.prepend(containerComment);
                    $("#comments_article").append(cardElt);




                    //comments child


                    if(commentElt.children){

                        commentElt.children.forEach(children =>{

                            let cardEltChildren=$("<div></div>").addClass("response_comment_card").attr({"id": "comment-"+children.id , "data-id-parent": children.id_parent});
                            
                            
                            let containerCommentChildren=$("<div></div>").addClass("container_comment");;
                        

                            let commentDivChild=$("<div></div>").addClass("comment").html(children.comment);
                            


                            users.forEach(user=>{

                                if(children.id_user == user.id){
        
                                    let userDivChild=createUserCard(user,children);
                                    $(containerCommentChildren).append(userDivChild);
                                }
                            })


                            if(account_confirmed != false){
     
     
                                const btnDiv=$("<div></div>").addClass("btn_comment_end");
                                

                                //form report comment
                                const formElt=$("<form></form>").addClass("report_comment");
    
                                const report_url=$(".report_comment").attr("action");

                                formElt.attr({"action":report_url, "method":"post", "data-id":children.id});
                            
                                
    
                                const btnReport=$("<button></button>").addClass("button-red").html("Signaler");

                                $(btnDiv).append(formElt);
                                $(formElt).append(btnReport);

                                if(current_user == children.id_user){

                                    const formDeleteComment=$("<form></form>").addClass("delete_comment").attr({"action": window.location.origin+"/projet-5/blog/delete_comment", "method":"post"});

                                    const btnDelete=$("<button></button>").addClass("button-red").html("Supprimer");

                                    const inputElt=$("<input/>").attr({"type" : "hidden", "value" : children.id, "name" : "comment_id"});

                                    $(formDeleteComment).append(btnDelete);
                                    $(formDeleteComment).append(inputElt);
                                    $(btnDiv).append(formDeleteComment);

                                }
                            
                                
    
                                
                                
                                $(cardEltChildren).append(btnDiv);
                                 
                             }


                            
                            $(containerCommentChildren).append(commentDivChild);
                            cardEltChildren.prepend(containerCommentChildren);
                    

                            $("#comments_article").append(cardEltChildren);

                        })
                    }
                    
                });

            }else{
                loadCommentsMsg.text("Aucun commentaire à charger");
            }
                
        }).

        fail(function(req){
            console.log(req.responseText);
        })
        
    }
});

});