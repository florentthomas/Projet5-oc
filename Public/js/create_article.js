jQuery(document).ready(function($){

    
    let image_accepted=false;


    $("#image_article").change(function(){

        const messageElt=$("#img_check");

        const image= this.files[0];

        const image_size= image.size / 1024;

        if(image_size < 2048){

            const allowedExtension = ['jpeg', 'jpg', 'png', 'gif'];
            
            const image_extension= image.name.split(".").pop().toLowerCase();


            for(let i = 0; i < allowedExtension.length; i++){

                if(image_extension === allowedExtension[i]){
                    image_accepted= true;
                    messageElt.html("image acceptée");
                    break;
                }
                else{
                    image_accepted= false;
                    messageElt.html("Format non conforme (jpg, png, gif)");
                }

            }
        }

        else{
            messageElt.html("L'image est trop grande (2Mo max)");
            image_accepted=false;
        }

    })




    $("#create_article").submit(function(){

        
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
