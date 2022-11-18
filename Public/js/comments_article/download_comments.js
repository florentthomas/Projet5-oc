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

                    const card_comment_parent=create_card_comment_parent(commentElt);

                    
                    users.forEach(user =>{

                        if(user.id == commentElt.id_user){

                            const userDiv=createUserCard(user,commentElt);
                            $(card_comment_parent).find(".container_comment").prepend(userDiv);
                            
                        }
                    })


                    if(account_confirmed != false){

                       //insert buttons response and report comment if user's account is valid

                        const btnDiv=$("<div></div>").addClass("btn_comment_end").append(create_form_report_comment(commentElt));
                    

                        //button response
                        const btnEltReponse=$("<button></button>").addClass("btn_response button-blue").attr("data-id", commentElt.id).html("Répondre");
                      
                        $(btnDiv).prepend(btnEltReponse);

                        const menu_sandwich=create_menu_hamburger()
                        
                        $(card_comment_parent).append(menu_sandwich,btnDiv);



                        //button delete comment

                        if(current_user == commentElt.id_user){

                            $(btnDiv).append(create_form_delete_comment(commentElt));

                        }
                       
                        
                    }

                    $("#comments_article").append(card_comment_parent);


                    //comments child


                    if(commentElt.children){

                        commentElt.children.forEach(commentChild =>{
                            
                            const card_comment_child=create_card_comment_child(commentChild);


                            users.forEach(user=>{

                                if(commentChild.id_user == user.id){

                                    card_comment_child.find(".container_comment").prepend(createUserCard(user,commentChild));
                                    
                                }
                            })


                            if(account_confirmed != false){
     
     
                                const btnDiv=$("<div></div>").addClass("btn_comment_end");
                           
                                $(btnDiv).append(create_form_report_comment(commentChild));
                               

                                if(current_user == commentChild.id_user){

                                    $(btnDiv).append(create_form_delete_comment(commentChild));

                                }
                            
                                
    
                                const menu_sandwich=create_menu_hamburger();
                                
                                $(card_comment_child).append(menu_sandwich,btnDiv);
                                 
                            }

                            $("#comments_article").append(card_comment_child);

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