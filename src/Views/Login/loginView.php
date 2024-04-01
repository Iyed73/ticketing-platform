<?php

function checkLoginErrors(){
    if(isset($_SESSION["login_errors"])){
        $errors = $_SESSION["login_errors"];
        echo "<br>";
        foreach ($errors as $error){
            echo "<p class=error-message>$error</p>";
        }

        unset($_SESSION["login_errors"]);
    }
}

function checkLoginSuccess(){
    if(isset($_GET["login"])){
        if($_GET["login"]=="success"){
            echo "<p class=success-message>Login successful!</p>"; 
        }
    }
}

function outputUsername(){
    if(isset($_SESSION["username"])){
        if($_SESSION["role"]=="admin")
            echo "<p class=success-message>Welcome, ".$_SESSION["username"].". You are logged in as an admin!</p>";
        else
            echo "<p class=success-message>Welcome, ".$_SESSION["username"].". You are logged in as customer"."!</p>";
    }
}