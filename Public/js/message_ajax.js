
function message_ajax(data){

    const result=$("#result");

    console.log(data);

    if(data.location){
        window.location.href = data.location;
    }

    else{
        result.removeClass("error success").addClass(data.attribute);     
        result.text(data.message);

    
        result.fadeIn();
        result.fadeOut(1500);

    }
}


