

jQuery(document).ready(function($){

    const form=$('#form_comment');

    $(document).delegate('.btn_response','click',function(e){


        const id_parent=e.target.dataset.id;

        const comment=$('#comment-'+ id_parent);

        form.find('textarea').attr('placeholder', "Répondre au commentaire");
        $('#id_parent').val(id_parent);

        $("#close_form").show();

        comment.after(form);

    
    })


    $('#close_form').click(function(e){

        e.preventDefault();

        const form_comment_article=$('#form_comment_article');

        $('#id_parent').val(0);

        form.find('textarea').attr('placeholder', "Ecrivez un commentaire");
        
        $('#close_form').hide();

        form_comment_article.append(form);

    })

});

