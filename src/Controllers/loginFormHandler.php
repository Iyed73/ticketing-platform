<?php
require_once "loginController.php";
if($_SERVER["REQUEST_METHOD"]=="POST"){

    $logincontroller = new loginController($_POST["email"],$_POST["password"]);
    $logincontroller->sanitizeInput();

    //ERROR HANDLING
    $errors = [];

    if($logincontroller->isInputEmpty()){
        $errors["empty_input"] = "Fill in all fields!";
    }
    if(!$logincontroller->isUserInDB()){
        $errors["user_not_found"] = "User not found!";
    }
    if(($logincontroller->isUserInDB())&&($logincontroller->isPasswordIncorrect())){
        $errors["incorrect_password"] = "Incorrect password";
    }
    //other error handling can be added here

    require_once("C:\\xampp\htdocs\\ticketing-platform\src\Controllers\includes\configSession.inc.php");

    if($errors){
        $_SESSION["login_errors"] = $errors;

        header("Location: ..\..\index.php?login=failed");
        die();
    }

    //If there are no errors, log in the user

    //setting up session variables
    
    $user = $logincontroller->getUser();
    $_SESSION["user_id"] = $user->id;
    $_SESSION["email"] = $user->email;
    $_SESSION["role"] = $user->role;
    
    //Create a new session id and append the user id to it for better security and association of data with the user for a personalized experience
    regenerate_session_id_loggedin();

    header("Location: ..\..\index.php?login=success");
    die();
}else{
    header("Location: ..\..\index.php?notpost");
    die();
}