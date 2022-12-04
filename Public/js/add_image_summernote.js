function sendfiles(file,el){
    
    let formData=new FormData();
    formData.append("file",file);


  
    const url= $(el).attr("data-url");
  
  
    $.ajax(
        {
            url: url,
            type: "POST",
            data:formData,
            dataType: "json",
            cache : false,
            processData: false,
            contentType: false
        }
    ).
        
    done(function(response){
  
        if(response.attribute == "error"){
            message_ajax(response)
        }
        else{
            $(el).summernote("editor.insertImage", response.url_image);
        }
        
    }).

    fail(function(){
        console.log("error");
    })
  
  }