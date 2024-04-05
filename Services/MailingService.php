<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require_once 'vendor\autoload.php';


function sendMail($sendorName, $receiverName, $email, $subject, $messageHtml, $messageText, $attachementPaths = null)
{
    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);
    try {
        //Server settings
        $mail->isSMTP(); //Send using SMTP
        $mail->Host = $_ENV['SMTPhost']; //Set the SMTP server to send through
        $mail->SMTPAuth = true; //Enable SMTP authentication
        $mail->Username = $_ENV['SMTPusername']; //SMTP username
        $mail->Password = $_ENV['SMTPpassword']; //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; //Enable TLS encryption; 
        $mail->Port = $_ENV['SMTPport']; //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom($_ENV['SMTPusername'], $sendorName);
        $mail->addAddress($email, $receiverName);                    //Add a recipient
        $mail->addReplyTo('tickety873@gmail.com', 'Tickety');

        //Attachments
        if ($attachementPaths != null) {
            foreach ($attachementPaths as $attachementPath)
                $mail->addAttachment($attachementPath);             //Add attachments
        }

        //Content
        $mail->isHTML(true);                                       //Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body = $messageHtml;
        $mail->AltBody = $messageText;

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}