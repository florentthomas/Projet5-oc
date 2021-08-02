function message_error_ajax(error){

    const result=$("#result");

    result.removeClass("success").addClass("error");     
    result.text("Une erreur est survenue, impossible d'executer la requête");
    result.fadeIn("slow");
    result.fadeOut(5000);
    console.error(error);
}