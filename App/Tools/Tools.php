<?php

namespace App\Tools;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

class Tools{

    public static function sendEmail($recipient,$subject,$message){

        $mail = new PHPMailer();

        
        //Server settings
        // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $mail->isSmtp();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'cine.film48522@gmail.com';                     //SMTP username
        $mail->Password   = 'ch-dhshz@ss8aP/sns5';                               //SMTP password
        $mail->SMTPSecure =PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('ne-pas-repondre@cinefilm.com', 'cine-film');
        $mail->addAddress($recipient);     //Add a recipient           
        

        //Content
        $mail->isHTML(true);                                  
        $mail->Subject = $subject;
        $mail->Body    = $message;
        

        if(!$mail->send()){
            return false;
        }

        else{
            return true;
        }
    }

}