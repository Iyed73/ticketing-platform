<?php
require_once "loginController.php";
if($_SERVER["REQUEST_METHOD"]=="POST"){
    $logincontroller = new loginController($_POST["username"],$_POST["password"]);
    $logincontroller->sanitizeInput();

    //ERROR HANDLING
    $errors = [];

    if($logincontroller->is_input_empty()){
        $errors["empty_input"] = "Fill in all fields!";
    }
    if(!$logincontroller->is_user_in_db()){
        $errors["user_not_found"] = "User not found!";
    }
    if(($logincontroller->is_user_in_db())&&($logincontroller->is_password_incorrect())){
        $errors["incorrect_password"] = "Incorrect password!";
    }
    //other error handling can be added here

    require_once("includes/configSession.inc.php");

    if($errors){
        $_SESSION["login_errors"] = $errors;

        header("Location: ../Views/loginForm.php");
        die();
    }

    //If there are no errors, log in the user

    $_SESSION["user_id"] = $logincontroller->getUserId();
    $_SESSION["username"] = $logincontroller->getUsername();
    
    //Create a new session id and append the user id to it for better security and association of data with the user for a personalized experience
    regenerate_session_id_loggedin();

    header("Location: ../Views/loginForm.php?login=success");
    die();
}else{
    header("Location: ../Views/loginForm.php");
    die();
}