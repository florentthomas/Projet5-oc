$(document).ready(function() {

    $('#message_user').summernote({
        height: 400,
    
        callbacks: {
            onImageUpload: function(files){
                
                for(let i = 0; i < files.length; i++){
                    sendfiles(files[i],this);
                }  
            
            }
        }
        
    });
    
});


