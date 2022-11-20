jQuery(document).ready(function($){



    $($("#menu_mobile_navbar")).click("click",(e)=>{


       $(".menu_navbar").toggleClass("menu_mobile_navbar_active")


       $("#menu_mobile_navbar").find("i").toggleClass("fa-solid fa-xmark");
   
        
    })


    
})