$(document).ready(function() {

    $('#message_user').summernote({
        height: 400,
    
        callbacks: {
            onImageUpload: function(file){
                
                sendfiles(file[0],this);
            
            }
        }
        
    });
    
});


