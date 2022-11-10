
function create_card_comment_parent(comment){

    let cardElt=$("<div></div>").addClass("comment_article_card").attr("id", "comment-"+comment.id);
                 
    let containerComment=$("<div></div>").addClass("container_comment");
    
    let commentDiv=$("<div></div>").addClass("comment").html(comment.comment);

    containerComment.append(commentDiv);
    cardElt.append(containerComment);

    return cardElt;
}