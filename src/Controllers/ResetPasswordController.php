<?php
require_once "src\Models\UserRepo.php";
require_once("src\Controllers\includes\configSession.inc.php");

/**
 This class is responsible for handling the request to reset the password.
 */

class ResetPasswordController {
    private $userTable;
    private $userId;
    private $newPassword;

    public function __construct() {
        $this->userTable = new UserRepo();
    }
    
    private function sanitize($input){
        return htmlspecialchars(stripslashes(trim($input)));
    }

    
    private function getData(){
        $prefix = $_ENV['prefix'];
        if(!isset($_POST['newPassword']) || !isset($_POST['newPasswordConfirm']) || !isset($_SESSION["userForgotId"])){
            header("Location: {$prefix}/");
            die();
        }

        $newPassword = $this->sanitize($_POST['newPassword']);
        $newPasswordConfirm = $this->sanitize($_POST['newPasswordConfirm']);

        if($newPassword !== $newPasswordConfirm){
            require_once "src/Views/passwordMismatch.php";
            die();
        }

        $this->userId = unserialize($_SESSION["userForgotId"]);
        $this->newPassword = $newPassword;
    }
    
    public function handleRequest(){
        $prefix = $_ENV['prefix'];
        $this->getData();
        

        $options = [
            'cost' => 12   //recommended value berween 10 and 12 (the higher the cost the more complex the hashing is the more time it will take a user to log in but better for security.
        ];
        $hashedPwd = password_hash($this->newPassword, PASSWORD_BCRYPT,$options);  //you can you PASSWORD_DEFAULT so that it automatically updates if user updates hashing methode. other options(PASSWORD_ARGON2I || PASSWORD_ARGON2ID winner of a password hashing competition)

        try {
            $this->userTable->updatePassword($this->userId, $hashedPwd);
            
            header("Location: {$prefix}/home?login=failed");
            die();
        } catch (Exception $e) {
            http_response_code(500);
            die();
        }   
    }
}

$resetPasswordController = new ResetPasswordController();
$resetPasswordController->handleRequest();


