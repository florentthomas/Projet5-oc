function message_error(message){

    const result=$("#result");
    result.removeClass("success").addClass("error"); 
    result.text(message);
    result.fadeIn("slow");
    result.fadeOut(5000);
}