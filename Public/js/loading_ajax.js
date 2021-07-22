function loading_ajax(){
  
    $("<div id='loading'></div>").css({"position": "absolute","width":"100%","height":"100%","background-color":"rgb(255,255,255,0.5"})
                    .prependTo("body");
    
    $("body").css("overflow", "hidden");
}