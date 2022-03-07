

function req_ajax(e){

    e.preventDefault();

    const formData=$(this).serialize();
    const url=$(this).attr("action");
    const method=$(this).attr("method");
    
    console.log(url);

    $.ajax({

        url: url,
        type: method,
        data: formData,
        dataType: "json"

    })
    
    .done(function(response){
        message_ajax(response);
    })
    
    .fail(function(req){
        console.error(req.responseText);
    })
}

   
