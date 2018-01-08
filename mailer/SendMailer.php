<?php
require 'PHPMailer Lib/PHPMailerAutoload.php';

function SendMail($to, $subject, $message)
{
      try{
        $mail = new PHPMailer(true);      //-->PHPMailer set to true - throw an exception if an error occurs
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = 'sysadmin@diwamail.com';                 // SMTP username
        $mail->Password = 'systemem@il';                           // SMTP password
        $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 587;                                    // TCP port to connect to

        $mail->FromName = 'IT ADMINISTRATOR (no-reply)';
        foreach($to as &$emailadd){
        $mail->addAddress($emailadd);     // Add a recipient
        }

        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body    = $message; 
        $mail->AltBody = $message;
        $mail->send();
        }
        catch(phpmailerException $e)
    {
        error_log(addslashes($e).PHP_EOL, 3, "emailErrLogs");
    }
        
}