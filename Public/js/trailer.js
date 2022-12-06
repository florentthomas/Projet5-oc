
jQuery(document).ready(function($){



    const iframeContainer=$("#trailer_embed");

   
    $("#trailer").click(function(e){

        e.preventDefault();

        iframeContainer.show();

    })




    $("#close_video").click(function(){


        $("#trailer_iframe")[0].src= $("#trailer_iframe")[0].src
    
        iframeContainer.hide();

    })



})