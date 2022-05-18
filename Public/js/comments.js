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
            message_error_ajax(response);
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

            console.log(commentElt);

            $("#test").hide();
            commentElt.hide();

            message_ajax(response);

        }).

        fail(function(response){
            message_error_ajax(response);
        })
    })


})