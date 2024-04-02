<?php
require_once "..\..\src\Controllers\signupLoginControllers\loginController.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $loginController = new loginController($_POST["email"], $_POST["password"]);
    $loginController->handleLoginForm();
} else {
    header("Location: /ticketing-platform/home?notpost");
    die();
}
