function message_error_ajax(error){

    const result=$("#result");
    result.removeClass("success").addClass("error");     
    result.text("Une erreur est survenue, impossible d'executer la requête");
    result.fadeIn();
    result.fadeOut(1500);
    console.error(error.responseText);
}