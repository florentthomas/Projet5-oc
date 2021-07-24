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

  

    $("#form_email").submit(function(e){

        e.preventDefault();

        const url=$(this).attr("action");
        const formData=$(this).serialize();

        const new_email=$("#email").val();
        const confirm_email=$("#email_confirm").val();

        if(new_email === confirm_email){

            loading_ajax();
            
            $.ajax({
                url: url,
                type: "POST",
                data:formData
    
            }).done(function(response){

                data=JSON.parse(response);
                console.log(data);
                result.addClass(data.attribute);       
                result.text(data.message);
                result.fadeIn("slow");
                result.fadeOut(5000);
                
                $("#email").val("");
                $("#email_confirm").val("");
     
    
                
            }).fail(function(){
                result.text("Une erreur est survenue");
            }).always(function(){
                $("#loading").remove();
                $("body").css("overflow","auto");
            });

        }else{

            
            result.addClass("error"); 
            result.text("Les adresses ne sont pas identiques");
            result.fadeIn("slow");
            result.fadeOut(5000);


        }
    })


    $("#form_password").submit(function(e){
        e.preventDefault();

        const url=$(this).attr("action");
        const formData=$(this).serialize();

        const current_password=$("#current_password").val();
        const new_password=$("#new_password").val();
        const confirm_password=$("#confirm_new_password").val();
        
        
        if(new_password === confirm_password){
            $.ajax({
                url:url,
                type:"POST",
                data:formData
            }).done(function(response){

                data=JSON.parse(response);
                result.addClass(data.attribute);       
                result.text(data.message);
                result.fadeIn("slow");
                result.fadeOut(5000);

                if(data.attribute === "success"){
                    $("#form_password").find("input").val("");
                }
                
            })

        }
        else if(password_conform !== true){
            result.addClass("error"); 
            result.text("Le mot de passe n'est pas assez sécurisé");
            result.fadeIn("slow");
            result.fadeOut(5000);

        }
        else{
            result.addClass("error"); 
            result.text("Les mots de passe ne sont pas identiques");
            result.fadeIn("slow");
            result.fadeOut(5000);
        }
    })
})

$("#new_password").keyup(safe_password);