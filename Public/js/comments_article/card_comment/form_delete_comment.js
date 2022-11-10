
function create_form_delete_comment(comment){

    const formDeleteComment=$("<form></form>").addClass("delete_comment").attr({"action": window.location.origin+"/projet-5/blog/delete_comment", "method":"post"});

    const btnDelete=$("<button></button>").addClass("button-red").html("Supprimer");

    const inputElt=$("<input/>").attr({"type" : "hidden", "value" : comment.id, "name" : "comment_id"});

    formDeleteComment.append(inputElt,btnDelete);

    return formDeleteComment;

}