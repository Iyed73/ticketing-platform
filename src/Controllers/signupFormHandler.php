<?php
require_once ("signupController.php");
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

    require_once ("includes/configSession.inc.php");

    if ($errors) {
        $_SESSION["signup_errors"] = $errors;

        $signupData = [
            "firstname" => $_POST["firstname"],
            "lastname" => $_POST["lastname"],
            "email" => $_POST["email"]
        ];
        $_SESSION["signup_data"] = $signupData;

        header("Location: ..\..\index.php?signup=failed");
        die();
    }

    //If there are no errors, create a new user

    $signupcontroller->addCustomer();
    header("Location: ..\..\index.php?signup=success");
    die();
} else {
    header("Location: ..\..\index.php?notpost");
    die();
}
