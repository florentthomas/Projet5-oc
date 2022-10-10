function createUserCard(user,commentElt){

        

    let userDiv=$("<div></div>");
    userDiv.addClass("user");

    let photoUser=$("<img/>").addClass("photo_profil");
    let pseudoDiv=$("<div></div>");
    let dateCommentDiv=$("<div></div>");


    photoUser.attr("src", user.photo);
    pseudoDiv.html(user.pseudo);
    dateCommentDiv.html(commentElt.date_comment);

    $(userDiv).append(photoUser);
    $(userDiv).append(pseudoDiv);
    $(userDiv).append(dateCommentDiv);
    

    return userDiv;
}