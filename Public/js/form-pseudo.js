jQuery(document).ready(function($){


    const result=$("#result");

    $("#form_pseudo").submit(function(e){


        e.preventDefault();

        const url=$(this).attr("action");
        const formData=$(this).serialize();

        $.ajax({
            url: url,
            type: "POST",
            data:formData

        }).done(function(response){

            data=JSON.parse(response);

            result.addClass(data.attribute);       
            result.text(data.message);
            result.fadeIn("slow");
            result.fadeOut(5000);
            
            $("#pseudo").val("");
 

            
        }).fail(function(){
            result.text("Une erreur est survenue");
        });




    })



})