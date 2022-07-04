
jQuery(document).ready(function($){

   

// this function gets called when API is ready to use

    const iframeContainer=$("#trailer_embed");
    const bodyElt=$("body");
    const iframeElt=$("#trailer_iframe")
   
    $('iframe[src*="https://www.youtube.com/embed/"]').addClass("youtube-iframe");

    $("#trailer").click(function(e){

        e.preventDefault();

        bodyElt.css("overflow","hidden");
        iframeContainer.show();

    })




    $("#close_video").click(function(){

        bodyElt.css("overflow","auto");
        $('.youtube-iframe').each(function(index) {
            $(this).attr('src', $(this).attr('src'));
            return false;
        });
        iframeContainer.hide();

    })



})



