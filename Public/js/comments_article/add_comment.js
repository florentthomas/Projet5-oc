jQuery(document).ready(function($){

    $("#form_comment").submit(function(e){

        e.preventDefault();

        const url=$(this).attr("action");
        const formData=$(this).serialize();

        $.ajax({
            url: url,
            type: "POST",
            data:formData,
            dataType: "json"

        })
        
            .done(function(response){

                

                if(response.attribute == "success"){

                   
                    const id_parent=$("#id_parent").val();

                    const fullDate = new Date();
                    const twoDigitMonth = ((fullDate.getMonth().length+1) === 1)? (fullDate.getMonth()+1) : '0' + (fullDate.getMonth()+1);
                    const currentDate = fullDate.getDate() + "/" + twoDigitMonth + "/" + fullDate.getFullYear();

 
                    const img_user=$("<img src='"+response.url_photo+"'/>").addClass("photo_profil");
                    const date=$("<div></div>").text(currentDate);
                    const user=$("<div></div>").addClass("user").append(img_user,date);


                    const comment=$("<div></div>").addClass("comment").text($("#comment_area").val());


                    const container_comment=$("<div></div>").addClass("container_comment").append(user,comment);

                    const comment_card=$("<div></div>").append(container_comment);

                    if(id_parent > 0){
                        
                        comment_card.addClass("response_comment_card");
                        $("#comment-"+id_parent).after(comment_card);
                    }
                    else{
                        comment_card.addClass("comment_article_card");
                        $("#comment_article").after(comment_card);
    
                    }

                    message_ajax(response);

                    $("#comment_area").val("");
                }

                else{
                    message_error(response);
                }

 
            })
            
            .fail(message_error_ajax);

    })

})