jQuery(document).ready(function($){



    $(document).on("click", ".menu_comment", (e)=>{


        $(e.currentTarget).next("div").toggleClass("menu_mobile_active")
   
        
    })




    
    $(document).on("click", ".menu_mobile_active", (e)=>{

        $(e.currentTarget).toggleClass("menu_mobile_active")

        
    })


    
})