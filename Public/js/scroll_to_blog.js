jQuery(document).ready(function($){


    const arrow= $("#chevron");

    arrow.click(function() {
        $([document.documentElement, document.body]).animate({
            scrollTop: $("#blog").offset().top
        }, 2000);
    });



})