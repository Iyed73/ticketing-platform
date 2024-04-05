<?php
require_once "src\Models\UserRepo.php";


/**
 This class is responsible for handling the recovery link sent to the user's email.
 */

class RecoverPasswordController {
    
    public function handleRequest(){
        $prefix = $_ENV['prefix'];
        if(!isset($_GET['token'])){
            header("Location: {$prefix}/");
            die();
        }
        
        require_once "src/Views/recoverPassword.php";
        die();
    }
}

$recoverPasswordController = new RecoverPasswordController();
$recoverPasswordController->handleRequest();


