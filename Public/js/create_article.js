jQuery(document).ready(function($){


    $("#create_article").submit(function(e){

        const content=CKEDITOR.instances['article'].getData();
        const image_article=$("#image_article");
        const result_elt=$("#result");
        

        if($("#title_article").val().length === 0 || $("#slug_article").val().length === 0 || $("#description").val().length === 0 ){
            e.preventDefault();
            result_elt.addClass("error");
            result_elt.text("Les champs ne sont pas tous remplis");
            result_elt.show();
           
        }else{

            const allowedExtension = ['jpeg', 'jpg', 'png', 'gif'];
            
            const image_extension= image_article.val().split(".").pop().toLowerCase();

            let extension_valide=false;

            for(let i = 0; i < allowedExtension.length; i++){

                if(image_extension === allowedExtension[i]){
                    extension_valide= true;
                    break;
                }

            }

            if(extension_valide === false){
                e.preventDefault();
                result_elt.addClass("error");
                result_elt.text("Aucune image sélectionnée ou le format n'est pas correct");
                result_elt.show();
            }
        }
    })


})
