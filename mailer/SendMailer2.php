<?php
require 'PHPMailer Lib/PHPMailerAutoload.php';

function SendMail($to, $subject, $message)
{
      
        $mail = new PHPMailer(true);      //-->PHPMailer set to true - throw an exception if an error occurs
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = 'sysadmin@diwamail.com';                 // SMTP username
        $mail->Password = 'systemem@il';                           // SMTP password
        $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 587;                                    // TCP port to connect to
        $mail->SMTPDebug = 2;
        $mail->Debugoutput = "html";
        $mail->FromName = 'IT ADMINISTRATOR (no-reply)';
        foreach($to as &$emailadd){
        $mail->addAddress($emailadd);     // Add a recipient
        }

        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body    = $message; 
        $mail->AltBody = $message;
        if(!$mail->send()){
            echo "Mailer Error: " . $mail->ErrorInfo;
        }else{
           echo "Message sent!"; 
        }
        
       
        
}