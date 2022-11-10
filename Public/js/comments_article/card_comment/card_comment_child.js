
function create_card_comment_child(commentChild){

    let cardEltChild=$("<div></div>").addClass("response_comment_card").attr({"id": "comment-"+commentChild.id , "data-id-parent": commentChild.id_parent});
                            
                            
    let containerCommentChild=$("<div></div>").addClass("container_comment");


    let commentDivChild=$("<div></div>").addClass("comment").html(commentChild.comment);

    containerCommentChild.append(commentDivChild);

    cardEltChild.append(containerCommentChild);

    return cardEltChild;

}