

function controle_image(img){

    const messageElt=$("#controle_img_msg");

    messageElt.show()

    const image= img;

    const image_size= image.size / 1024;

    if(image_size < 2048){

        const allowedExtension = ['jpeg', 'jpg', 'png', 'gif'];
        
        const image_extension= image.name.split(".").pop().toLowerCase();


        for(let i = 0; i < allowedExtension.length; i++){

            if(image_extension === allowedExtension[i]){
                messageElt.html("image acceptée");
                return true;
            }

        }

        messageElt.html("Format non conforme (jpg, png, gif)");
        return false
    }

    else{
        messageElt.html("L'image est trop grande (2Mo max)");
        return false;
    }

}