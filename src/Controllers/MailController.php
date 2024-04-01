<?php 
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require_once 'includes/vendor/autoload.php';



function sendMail($username, $email, $subject, $messageHtml,$messageText, $attachementPath=null) {
    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);
    try {
        //Server settings
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.mailersend.net';                  //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'MS_oVW7p2@trial-0p7kx4xqd1mg9yjr.mlsender.net';               //SMTP username
        $mail->Password   = 'KV9J6Zm3UMxgxlfT';                                    //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         //Enable TLS encryption; 
        $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('MS_oVW7p2@trial-0p7kx4xqd1mg9yjr.mlsender.net', 'Tickety');
        $mail->addAddress($email, $username);                      //Add a recipient
        $mail->addReplyTo('tickety873@gmail.com', 'Tickety');

        //Attachments
        if ($attachementPath != null) {
            $mail->addAttachment($attachementPath, 'file.pdf');    //Optional name
        }

        //Content
        $mail->isHTML(true);                                       //Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body    = $messageHtml;
        $mail->AltBody = $messageText;

        $mail->send();
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}


function generateSingUpMessageHtml($username){
    return "<h1>Welcome to Tickety</h1><br><p>Dear $username, <br>Thank you for signing up with us. We are excited to have you on board. <br>Best Regards, <br>Tickety Team</p>";
}

function generateSignUpMessageText($username){
    return "Welcome to Tickety\n\nDear $username,\nThank you for signing up with us. We are excited to have you on board.\n\nBest Regards,\nTickety Team";
}

//add other message generation functions here

