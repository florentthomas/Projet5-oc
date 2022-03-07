jQuery(document).ready(function($){


    
    
    //Changement du titre

    $("#form_title_article").submit(req_ajax);



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
            data: data
        })
        . done(function(response){
            console.log(response);
        })
        .fail(function(rq){
            console.error(rq);
        })
    });



    //changement slug

    $("#form_slug_article").submit(req_ajax);


    //Changement_description

    $("#form_description_article").submit(req_ajax);


    //changement contenu
    $("#form_content_article").submit(req_ajax);
    

})

