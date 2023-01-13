function comment_child_template(comment_child,account_confirmed = true,current_user){

    

        const template= document.getElementById("comment-child")

        const clone_comment_child  = document.importNode(template.content, true)
    
    
    
        const comment_article_card_elt=clone_comment_child .querySelector(".response_comment_card")
    
        const photo_profil_elt=clone_comment_child .querySelector(".photo_profil")
    
        const btn_comment_end_elt=clone_comment_child .querySelector(".btn_comment_end")
    
        const pseudo_elt=clone_comment_child .querySelector(".pseudo")
    
        const date_comment_elt= clone_comment_child .querySelector(".date_comment") 
    
        const comment_elt=clone_comment_child .querySelector(".comment")
    
        const menu_comment_elt=clone_comment_child .querySelector(".menu_comment")
    
        const form_delete_comment_elt=clone_comment_child .querySelector(".delete_comment")




        comment_article_card_elt.setAttribute("id", "comment-"+comment_child.id)

        comment_article_card_elt.setAttribute("data-parent-id", comment_child.id_parent)

      
        if(comment_child.user != false){
            photo_profil_elt.setAttribute("alt" , "Photo de profil de "+comment_child.user.pseudo)
            photo_profil_elt.setAttribute("src" , comment_child.user.photo)
            pseudo_elt.innerText=comment_child.user.pseudo
            date_comment_elt.innerText=comment_child.date_comment
        }
    
        else{
            photo_profil_elt.remove()
            pseudo_elt.innerText="profil supprimé"
            date_comment_elt.innerText=comment_child.date_comment
            
        }


        comment_elt.innerText=comment_child.comment


        if(account_confirmed == true){
            
            const form_report_comment_elt=clone_comment_child .querySelector(".report_comment")
            const input_hidden_report_comment_elt=clone_comment_child .querySelector(".report_comment_input")
          
            input_hidden_report_comment_elt.setAttribute("value", comment_child.id)

        }

        else{
            btn_comment_end_elt.remove()
            menu_comment_elt.remove()
        }

        

        if(current_user == comment_child.id_user){
            const input_hidden_delete_comment_elt=clone_comment_child .querySelector(".delete_comment_input")
            input_hidden_delete_comment_elt.setAttribute("value", comment_child.id)
        }

        else{
            form_delete_comment_elt.remove()
        }
         

        return clone_comment_child

    

        
}