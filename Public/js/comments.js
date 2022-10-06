jQuery(document).ready(function($){



    $(".delete_comment").click(function(e){
        e.preventDefault();

        const url= $(this).attr("href");

        const commentElt=$(this).parents("div.comment_article_card");
        

        $.ajax({
            url: url,
            dataType:"json"
        }).

        done(function(response){

            console.log(commentElt);

            $("#test").hide();
            commentElt.hide();

            message_ajax(response);

        }).

        fail(function(response){
            message_ajax(response.responseJSON);

            setTimeout(function(){
                window.location.href=response.responseJSON.redirect;
              }, 2000);;
        })
    })


    $(".approve_comment").click(function(e){
        e.preventDefault();

        const url= $(this).attr("href");

        const commentElt=$(this).parents("div.comment_article_card");
        

        $.ajax({
            url: url,
            dataType:"json"
        }).

        done(function(response){


            $("#test").hide();
            commentElt.hide();

            message_ajax(response);

        }).

        fail(function(response){
            message_ajax(response.responseJSON);

            setTimeout(function(){
                window.location.href=response.responseJSON.redirect;
              }, 2000);
        })
    })


})