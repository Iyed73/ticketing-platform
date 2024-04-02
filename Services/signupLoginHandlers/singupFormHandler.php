<?php

require_once "..\..\src\Controllers\signupLoginControllers\signupController.php";

/* require_once("MailController.php");
 */
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $signupcontroller = new signupController($_POST["firstname"], $_POST["lastname"], $_POST["email"], $_POST["password"]);
    $signupcontroller->sanitizeInput();

    //ERROR HANDLING
    $errors = [];

    if ($signupcontroller->is_input_empty()) {
        $errors["empty_input"] = "Fill in all fields!";
    }
    if ($signupcontroller->is_email_invalid()) {
        $errors["invalid_email"] = "Invalid email!";
    }
    if ($signupcontroller->is_email_taken()) {
        $errors["email_taken"] = "Email already taken!";
    }
    //other error handling can be added here

    require_once ("C:\\xampp\htdocs\\ticketing-platform\src\Controllers\includes\configSession.inc.php");

    if ($errors) {
        $_SESSION["signup_errors"] = $errors;

        $signupData = [
            "firstname" => $_POST["firstname"],
            "lastname" => $_POST["lastname"],
            "email" => $_POST["email"]
        ];
        $_SESSION["signup_data"] = $signupData;


        header("Location: /ticketing-platform/home?signup=failed");
        die();
    }

    //If there are no errors, create a new user

    $signupcontroller->addCustomer();
/*     sendMail($_POST["email"],$_POST["email"],"Welcome to Tickety",generateSingUpMessageHtml($_POST["email"]),generateSignUpMessageText($_POST["email"]));
 */    header("Location: /ticketing-platform/home?signup=success");

    die();
} else {
    header("Location: /ticketing-platform/home?notpost");
    die();
}
