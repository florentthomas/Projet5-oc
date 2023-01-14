

$(document).ready(function() {

  




    $('#textaera_summernote').summernote({

      toolbar: [
        ['style', ['style','bold', 'italic', 'underline', 'clear']],
        ['font', ['strikethrough', 'superscript', 'subscript']],
        ['fontsize', ['fontsize']],
        ['color', ['color']],
        ['table', ['table']],
        ['para', ['ul', 'ol', 'paragraph']],
        ['insert', ['link', 'picture', 'video']],
        ['height', ['height']],
        ['view', ['fullscreen', 'codeview', 'help']],
        ['fontname', ['fontname']],
       
      ],

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
    





