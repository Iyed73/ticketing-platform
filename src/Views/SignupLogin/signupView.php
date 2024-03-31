<?php

function checkSignupErrors(){
    if(isset($_SESSION["signup_errors"])){
        $errors = $_SESSION["signup_errors"];
        echo "<br>";
        foreach ($errors as $error){
            echo "<p class=error-message>$error</p>";
        }

        unset($_SESSION["signup_errors"]);
    }
}

function checkSignupSuccess(){
    if(isset($_GET["signup"])){
        if($_GET["signup"]=="success"){
            echo "<p class=success-message>Signup successful!</p>"; 
        }

    }
}