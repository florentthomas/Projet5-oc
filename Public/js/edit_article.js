jQuery(document).ready(function($){


    
    
    //Changement du titre

    $("#form_title_article").submit(function(e){

        e.preventDefault();

        const formData=$(this).serialize();
        const url=$(this).attr("action");
        const method=$(this).attr("method");
      
    
        $.ajax({
    
            url: url,
            type: method,
            data: formData,
            dataType: "json"
    
        })
        
        .done(function(response){
            message_ajax(response);
        })
        
        .fail(function(response){
            message_ajax(response.responseJSON);

            setTimeout(function(){
                window.location.href=response.responseJSON.redirect;
            }, 2000);
        })
    });



    //Changement photo

    $("#form_photo_article").submit(function(e){
        e.preventDefault();

        const data=new FormData(this);
        const url=$(this).attr("action");
        const method=$(this).attr("method");
       

        $.ajax({
            url: url,
            method:method,
            processData: false, 
            contentType: false,
            data: data,
            dataType: "json"
        })
        .done(function(response){
            
            message_ajax(response)

            const img=$("#prev_image").attr("src");

            const current_img=$("#current_img");

            current_img.hide();

            $("#prev_image_block").hide();

            current_img.attr("src", img);

            current_img.fadeIn();

            

        })

        .fail(function(rq){
            message_error_ajax(rq);
        })
    });



    //changement slug

    $("#form_slug_article").submit(function(e){

        e.preventDefault();

        const formData=$(this).serialize();
        const url=$(this).attr("action");
        const method=$(this).attr("method");
      
    
        $.ajax({
    
            url: url,
            type: method,
            data: formData,
            dataType: "json"
    
        })
        
        .done(function(response){
            console.log("test");
            message_ajax(response);
        })
        
        .fail(function(response){
            console.log("fail");
            message_ajax(response.responseJSON);

            setTimeout(function(){
                window.location.href=response.responseJSON.redirect;
            }, 2000);
        })
    });


    //Changement_description

    $("#form_description_article").submit(function(e){
        e.preventDefault();

        const formData=$(this).serialize();
        const url=$(this).attr("action");
        const method=$(this).attr("method");
      
    
        $.ajax({
    
            url: url,
            type: method,
            data: formData,
            dataType: "json"
    
        })
        
        .done(function(response){
            message_ajax(response);
        })
        
        .fail(function(response){
            message_ajax(response.responseJSON);

            setTimeout(function(){
                window.location.href=response.responseJSON.redirect;
            }, 2000);
        })
    });


    //changement contenu
    $("#form_content_article").submit(function(e){

        e.preventDefault();

        const content=CKEDITOR.instances['article'].getData();
        const url=$(this).attr("action");
        const method=$(this).attr("method");
        const id=$("#id_article").attr("value");
        

        $.ajax({
            url: url,
            method:method,
            data:{ "content_article": content,
                    "id_article": id},
            dataType: "JSON"
        })
        . done(function(response){
            message_ajax(response);

        })
        .fail(function(response){
            message_ajax(response.responseJSON);

            setTimeout(function(){
                window.location.href=response.responseJSON.redirect;
            }, 2000);
        })
    });
    

})

