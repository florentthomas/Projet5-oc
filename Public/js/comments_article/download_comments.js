jQuery(document).ready(function($){

    

 

let current_page=1;


const loadCommentsMsg=$("#load_comments_msg");

const url=$("#comments").attr("data-url");

const id_article=$("#comments").attr("data-id-article");



$(window).scroll(function() {

    if($(window).scrollTop() == $(document).height() - $(window).height()) {

        current_page++;

        loadCommentsMsg.text("Chargement des commentaires");

        $("#comments_article").append(loadCommentsMsg);

        $.ajax({
            url: url,
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

            
            if(comments.length != 0){


                comments.forEach(comment => {

                  

                    $("#comments_article").append(comment_parent_template(comment,account_confirmed,current_user))

                    if(comment.children !== undefined && comment.children.length != 0){

                 
                        comment.children.forEach(comment_child =>{

                            $("#comments_article").append(comment_child_template(comment_child,account_confirmed,current_user))

                        })    

                    }
                   
                });


            }else{
                loadCommentsMsg.text("Aucun commentaire à charger");
            }
                
        }).

        fail(function(req){
            message_error_ajax(req)
        })
        
    }
});

});