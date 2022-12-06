jQuery(document).ready(function($){

    
    let image_accepted=false;


    $("#image_article").change(function(){


       image_accepted= img_change_event(this)

    })




    $("#create_article").submit(function(e){

        const content=$(this).find("#article").summernote("code");
        const result_elt=$("#result");
        
        
        if($("#title_article").val().length === 0 || $("#slug_article").val().length === 0 || $("#description").val().length === 0 || content.length === 0){
            e.preventDefault();
            result_elt.addClass("error");
            result_elt.text("Les champs ne sont pas tous remplis");
            result_elt.show();
           
        }else{


            if(image_accepted === false){
                e.preventDefault();
                result_elt.addClass("error");
                result_elt.text("Aucune image sélectionnée ou le format n'est pas correct");
                result_elt.show();
            }
        }
    })

})
