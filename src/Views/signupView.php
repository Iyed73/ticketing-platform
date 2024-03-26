<?php

function signupInput(){
    //fill input fields with data if it exists
    echo '<label for="firstname">First Name:</label>';
    if(isset($_SESSION["signup_data"]["firstname"])){
        echo '<input id="firstname" name="firstname" type="text" placeholder="firstname" value="'. $_SESSION["signup_data"]["firstname"].'">';
    }
    else{
        echo '<input id="firstname" name="firstname" type="text" placeholder="firstname">';
    }
    echo "<br>";
    echo'<label for="lastname">Last Name:</label>';
    if(isset($_SESSION["signup_data"]["lastname"])){
        echo '<input id="lastname" name="lastname" type="text" placeholder="lastname" value="'. $_SESSION["signup_data"]["lastname"].'">';
    }
    else{
        echo '<input id="lastname" name="lastname" type="text" placeholder="lastname">';
    }
    echo "<br>";
    echo'<label for="username">username:</label>';
    if((isset($_SESSION["signup_data"]["username"]))&&(!isset($_SESSION["signup_errors"]["username_taken"]))){
        echo '<input id="username" name="username" type="text" placeholder="username" value="'. $_SESSION["signup_data"]["username"].'">';
    }
    else{
        echo '<input id="username" name="username" type="text" placeholder="username">';
    }
    echo "<br>";
    echo'<label for="email">Email:</label>';
    if((isset($_SESSION["signup_data"]["email"]))&&(!isset($_SESSION["signup_errors"]["email_taken"]))&&(!isset($_SESSION["signup_errors"]["invalid_email"]))){
        echo '<input id="email" name="email" type="email" placeholder="email" value="'. $_SESSION["signup_data"]["email"].'">';
    }
    else{
        echo '<input id="email" name="email" type="email" placeholder="email">';
    }
    echo "<br>";
    echo'<label for="password">Password:</label>';
    echo '<input id="password" name="password" type="password" placeholder="password">';
    echo "<br>";
    unset($_SESSION["signup_data"]);
}

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