<?php
require_once "..\..\Controllers\signupLoginControllers\loginController.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $loginController = new loginController($_POST["email"], $_POST["password"]);
    $loginController->handleLoginForm();
} else {
    header("Location: ..\..\index.php?notpost");
    die();
}
