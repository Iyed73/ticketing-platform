<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'C:\xampp\htdocs\ticketing-platform\lib\phpmailer\PHPMailer-master\src\Exception.php';
require 'C:\xampp\htdocs\ticketing-platform\lib\phpmailer\PHPMailer-master\src\PHPMailer.php';
require 'C:\xampp\htdocs\ticketing-platform\lib\phpmailer\PHPMailer-master\src\SMTP.php';



if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];
    $date = date('Y-m-d H:i:s');
    $status = 'pending';

/*     $emailTo = "euseifchouchane@gmail.com";
 */

    try {
        require_once "C:\\xampp\htdocs\\ticketing-platform\Database\includes\dbh.inc.php";


        $query = "INSERT INTO form_submissions (name, email, subject, message, date, status) VALUES (:name, :email, :subject, :message, :date, :status);";
        $stmt = $pdo->prepare($query);

        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':subject', $subject, PDO::PARAM_STR);
        $stmt->bindParam(':message', $message, PDO::PARAM_STR);
        $stmt->bindParam(':date', $date, PDO::PARAM_STR);
        $stmt->bindParam(':status', $status, PDO::PARAM_STR);
    
        $stmt->execute();

        $pdo = null;
        $stmt = null;


      


        header("Location: /ticketing-platform/contact.php?mailsend");
        die("query successful");
    } catch (PDOException $e) {
        die("query failed: " . $e->getMessage());
    }

} else {
    header("Location: ../contact.php?mailsend");
}

  /* $mail = new PHPMailer(true);

        $mail->isSMTP();
        $mail->Host = 'smtp.mailersend.net';
        $mail->SMTPAuth = true;
        $mail->Username = 'MS_T2fsYd@trial-3vz9dlej3jn4kj50.mlsender.net';
        $mail->Password = 'Pbe91MWt8495UWNk';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom($email);
        $mail->addAddress($emailTo);

        $mail->isHTML(true);

        $mail->Subject = $subject;
        $mail->Body = $message;

        $mail->send(); */
        /* catch(Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    } */