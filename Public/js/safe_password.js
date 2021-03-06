let password_conform=false;
let boolUpperCase=false;
let boolLowerCase=false;
let boolNumber=false;
let boolSpecialCharactere=false;
let boolLengthPassword=false;


function safe_password(){

    const upperCase=$("#upper_case");
    const lowerCase=$("#lower_case");
    const number=$("#number");
    const specialCharacter=$("#special_character");
    const lengthPassword=$("#length_password");

    const password_1=$(this).val();

    
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
        password_conform=true;
    }else{
        password_conform=false;
    }

}