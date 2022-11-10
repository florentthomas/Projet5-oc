
function create_form_report_comment(comment){

    const formElt=$("<form></form>").addClass("report_comment").attr({"action": window.location.origin+"/projet-5/blog/report_comment", "method":"post"});
    
    const inputElt=$("<input/>").attr({"value" : comment.id , "type" : "hidden" , "name" : "comment_id"});

    const btnReport=$("<button></button>").addClass("button-red").html("Signaler");

    formElt.append(inputElt,btnReport);

    return formElt;

}