
function message_ajax(response){

    const result=$("#result");

    data=JSON.parse(response);
    result.removeClass("error success").addClass(data.attribute);     
    result.text(data.message);
    result.fadeIn("slow");
    result.fadeOut(5000);

}


