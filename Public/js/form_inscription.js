jQuery(document).ready(function($){

    let safe_password=false;
    let boolUpperCase=false;
    let boolLowerCase=false;
    let boolNumber=false;
    let boolSpecialCharactere=false;
    let boolLengthPassword=false;




    $("#form_inscription").submit(function(e){
        e.preventDefault();
        

        const password_1=$("#password_1").val();
        const password_2=$("#password_2").val();
        const message_password=$("#message_password");

        if(password_1 === password_2 && safe_password === true){
            const url=$(this).attr("action");
            const formData=$(this).serialize();

            $.ajax({
                url: url,
                type: "POST",
                data:formData
            }).done(function(response){
                
                let data=JSON.parse(response);

                if(data.attribute === "error"){
                    
                    $("#response").addClass("error");
                }
                else if(data.attribute === "success"){
                    $("input","#form_inscription").val('');
                    $("#message_password").hide();
                    $("#response").addClass("success");
                }

                $("#response").html(data.message).fadeIn();   

                
            }).fail(function(){
                $("#res").text("Une erreur est survenue, echec de l'envoie du formulaire");
            });

        }

        else if(password_1 !== password_2){
            $("#password_2").css("border","1px solid red");
            message_password.show().css("color","red").text("Les mots de passe ne sont pas identiques");
        }
        
    });


    

    $("#password_1").change(function(){
        
        const upperCase=$("#upper_case");
        const lowerCase=$("#lower_case");
        const number=$("#number");
        const specialCharacter=$("#special_character");
        const lengthPassword=$("#length_password");

        const password_1=$("#password_1").val();

        
        if(password_1.length >= 12 ){
            lengthPassword.removeClass("invalid").addClass("valid");
            boolLengthPassword=true;
        }else{
            lengthPassword.removeClass("valid").addClass("invalid");
            boolLengthPassword=false;
        }


        if(/[a-z]/.test(password_1)){
            lowerCase.removeClass("invalid").addClass("valid");
            boolLowerCase=true;
        }else{
            lowerCase.removeClass("valid").addClass("invalid");
            boolLowerCase=false;
        }


        if(/[A-Z]/.test(password_1)){
            upperCase.removeClass("invalid").addClass("valid");
            boolUpperCase=true;
        }else{
            upperCase.removeClass("valid").addClass("invalid");
            boolUpperCase=false;
        }


        if(/[0-9]/.test(password_1)){
            number.removeClass("invalid").addClass("valid");
            boolNumber=true;
        }else{
            number.removeClass("valid").addClass("invalid");
            boolNumber=false;
        }


        if(/[@?!_%()#]/.test(password_1)){
            specialCharacter.removeClass("invalid").addClass("valid");
            boolSpecialCharactere=true;
        }else{
            specialCharacter.removeClass("valid").addClass("invalid");
            boolSpecialCharactere=false;
        }

        if(boolSpecialCharactere === true && boolLengthPassword === true && boolLowerCase === true && boolNumber === true && boolUpperCase === true){
            safe_password=true;
        }else{
            safe_password=false;
        }

       

    })



});