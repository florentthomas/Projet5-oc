jQuery(document).ready(function(){

    const btnDelete=$("#delete_image");
    const inputElt=$("#image_article");
    const btnSubmit=$("#btn_form_img");

    inputElt.change(function(){

        if(btnDelete.css("display") === "none"){
            btnDelete.show();
            btnSubmit.show();
        }
    })

    btnDelete.click(function(e){
        e.preventDefault();
        inputElt.val("");
        $("#prev_image").attr("src","");
        btnDelete.hide();
        btnSubmit.hide();
    })
})