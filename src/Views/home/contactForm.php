<?php

use PHPMailer\PHPMailer\PHPMailer;

require 'C:\xampp\htdocs\ticketing-platform\lib\phpmailer\PHPMailer-master\src\Exception.php';
require 'C:\xampp\htdocs\ticketing-platform\lib\phpmailer\PHPMailer-master\src\PHPMailer.php';
require 'C:\xampp\htdocs\ticketing-platform\lib\phpmailer\PHPMailer-master\src\SMTP.php';



if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = htmlspecialchars($_POST['name']);
    $emailFrom = htmlspecialchars($_POST['email']);
    $subject = htmlspecialchars($_POST['subject']);
    $message = htmlspecialchars($_POST['message']);

    $emailTo = "euseifchouchane@gmail.com";
    $headers = "[TICKETY] Contact Form Submission From: " . $emailFrom;
    $txt = "You have received an email from " . $name . ".\n\n" . $message;

    $mail = new PHPMailer(true);

    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'euseifchouchane@gmail.com';
    $mail->Password = 'dfgn xxbx uvkf kati';
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465;

    $mail->setFrom($emailFrom);
    $mail->addAddress($emailTo);

    $mail->isHTML(true);

    $mail->Subject = $subject;
    $mail->Body = $txt;

    $mail->send();
    header("Location: /ticketing-platform/contact.php?mailsend");

} else {
    header("Location: ../contact.php?mailsend");
}

