<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];
    $date = date('Y-m-d H:i:s');
    $status = 'pending';


    try {
        require_once "..\..\Models\FormSubmissionsRepo.php";

        $formSubmissionsRepo = new FormSubmissionsRepo();
        $formSubmissionsRepo->insertFormSubmission($email, $subject, $message, $status, $date);

        header("Location: /ticketing-platform/contact.php?mailsend");
        die("query successful");
    } catch (PDOException $e) {
        die("query failed: " . $e->getMessage());
    }

} else {
    header("Location: ../../../contact.php?error=notpost");
}
