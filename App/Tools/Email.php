<?php

namespace App\Tools;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;



class Email{

    public static function sendEmail($recipient,$subject,$message){

        $mail = new PHPMailer(true);

       try{
            $mail->setLanguage('fr');
            // $mail->SMTPDebug = //SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            $mail->isSmtp();                                            //Send using SMTP
            $mail->Host       = 'smtp.office365.com';                 //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = EMAIL;                     //SMTP username
            $mail->Password   = EMAIL_PASSWORD;                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;          //Enable implicit TLS encryption
            $mail->Port       = 587;                               //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom(EMAIL, 'cine-film');
            $mail->addAddress($recipient);              
            

            //Content
            $mail->isHTML(true);                                  
            $mail->Subject = $subject;

          
            $mail->Body= $message;
           

            $mail->send();

            return true;
      
        }

        catch(\Exception $e){
            
            return $e->getMessage();
        }
       
    }

    public static function generate_email($file,$data){

            $file_email=PATH_ROOT."App/Views/emails/".$file.".php";
            
            if(file_exists($file_email)){
                extract($data);
                ob_start();
                require $file_email;
                return ob_get_clean();
            }
            else{
                return false;
            }
    }


    // public static function generate($file,$data=[],$title){

    
    //     $content=Email::generateFile(PATH_ROOT."App/Views/emails/".$file.".php", $data);

    //     $view=Email::generateFile(PATH_ROOT."App/views/Template_email.php",array('title' => $title,
    //                                                                                 'content' => $content));

        
       
        
        
    // }


    // private static function generateFile($file,$data){

    //     if(file_exists($file)){
    //         extract($data);
    //         ob_start();
    //         require $file;
    //         return ob_get_clean();
    //     }
    // }
}