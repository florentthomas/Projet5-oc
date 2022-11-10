function createUserCard(user,commentElt){

        

    let userDiv=$("<div></div>").addClass("user");

    let photoUser=$("<img/>").addClass("photo_profil").attr("src", user.photo);
    let pseudoDiv=$("<div></div>").html(user.pseudo);
    let dateCommentDiv=$("<div></div>").html(commentElt.date_comment);

    
    $(userDiv).append(photoUser,pseudoDiv,dateCommentDiv);
    
    return userDiv;
}