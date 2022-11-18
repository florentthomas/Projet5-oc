


function create_menu_hamburger(){

    const spanElt=$("<span></span>").addClass("menu_comment");

    const liElt=$("<li></li>").addClass("fa-solid fa-list");

    spanElt.append(liElt)

    return spanElt
}