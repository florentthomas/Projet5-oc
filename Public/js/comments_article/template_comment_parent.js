function comment_parent_template( comment_parent, account_confirmed = true, current_user){


    const template= document.getElementById("comment-parent")

    const clone_comment_parent = document.importNode(template.content, true)



    const comment_article_card_elt=clone_comment_parent.querySelector(".comment_article_card")

    const photo_profil_elt=clone_comment_parent.querySelector(".photo_profil")

    const btn_comment_end_elt=clone_comment_parent.querySelector(".btn_comment_end")

    const pseudo_elt=clone_comment_parent.querySelector(".pseudo")

    const date_comment_elt= clone_comment_parent.querySelector(".date_comment") 

    const comment_elt=clone_comment_parent.querySelector(".comment")

    const menu_comment_elt=clone_comment_parent.querySelector(".menu_comment")

    const form_delete_comment_elt=clone_comment_parent.querySelector(".delete_comment")



    comment_article_card_elt.setAttribute("id" , "comment-"+comment_parent.id)



    if(comment_parent.user != false){
        photo_profil_elt.setAttribute("alt" , "Photo de profil de "+comment_parent.user.pseudo)
        photo_profil_elt.setAttribute("src" , comment_parent.user.photo)
        pseudo_elt.innerText=comment_parent.user.pseudo
        date_comment_elt.innerText=comment_parent.date_comment
    }

    else{
        photo_profil_elt.remove()
        pseudo_elt.innerText="profil supprimé"
        date_comment_elt.innerText=comment_parent.date_comment
        
    }

    comment_elt.innerText=comment_parent.comment

    if(account_confirmed == true){
        const btn_response_elt=clone_comment_parent.querySelector(".btn_response")
        const form_report_comment_elt=clone_comment_parent.querySelector(".report_comment")
        const input_hidden_report_comment_elt=clone_comment_parent.querySelector(".report_comment_input")

        btn_response_elt.setAttribute("data-id", comment_parent.id)

    
        input_hidden_report_comment_elt.setAttribute("value", comment_parent.id)

    }

    else{
        menu_comment_elt.remove()
        btn_comment_end_elt.remove()
    }




    if(current_user == comment_parent.id_user){
        const input_hidden_delete_comment_elt=clone_comment_parent.querySelector(".delete_comment_input")
        input_hidden_delete_comment_elt.setAttribute("value", comment_parent.id)
    }

    else{
        form_delete_comment_elt.remove()
    }


    return clone_comment_parent
   
}