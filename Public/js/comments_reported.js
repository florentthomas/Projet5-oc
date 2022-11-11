jQuery(document).ready(function($){



    $(".delete_comment").submit(function(e){
        e.preventDefault();

        const url= $(this).attr("action");
        const formData=$(this).serialize();
        const commentElt=$(this).parents("div.comment_article_card");
        const method= $(this).attr("method");
        

        $.ajax({
            url: url,
            method:method,
            data: formData,
            dataType:"json"
        }).

        done(function(response){

            message_ajax(response);

            if(response.attribute == "success"){
                commentElt.hide();
            }

        }).

        fail(function(response){

            message_ajax(response.responseJSON);

            setTimeout(function(){
                window.location.href=response.responseJSON.redirect;
              }, 2000);
        })
    })


    $(".approve_comment").submit(function(e){

        e.preventDefault();

        const url= $(this).attr("action");
        const formData=$(this).serialize();
        const method=$(this).attr("method");
        const commentElt=$(this).parents("div.comment_article_card");
        

        $.ajax({
            url: url,
            data: formData,
            method: method,
            dataType:"json"
        }).

        done(function(response){

            message_ajax(response);

            if(response.attribute == "success"){
                commentElt.hide();
            }

            

        }).

        fail(function(response){
            message_ajax(response.responseJSON);

            setTimeout(function(){
                window.location.href=response.responseJSON.redirect;
              }, 2000);
        })
    })


})