<?php
require_once "src\Models\TokenRepo.php";
require_once "src\Models\UserRepo.php";


/**
 This class is responsible for handling the recovery link sent to the user's email.
 */

class RecoverPasswordController {
    private $token;
    private $tokenTable;
    private $userTable;
    private $userId;

    public function __construct() {
        $this->userTable = new UserRepo();
        $this->tokenTable = new TokenRepo();
    }
    
    private function sanitize($input){
        return htmlspecialchars(stripslashes(trim($input)));
    }

    private function isTokenInvalid() {
        return !$this->token || strtotime($this->token->expires_at) < time() 
        || $this->token->type !== 'forgot_password';
    }

    private function getData(){
        $prefix = $_ENV['prefix'];
        if(!isset($_GET['token'])){
            header("Location: {$prefix}/");
            die();
        }

        $token = $this->sanitize($_GET['token']);
        $this->token = $this->tokenTable->findByToken($token);

        if($this->isTokenInvalid()){
            require_once "src/Views/invalidToken.php";
            die();
        }

        $this->userId = $this->token->user_id;

        $this->tokenTable->deleteByToken($token);
    }
    
    public function handleRequest(){
        $this->getData();
        require_once "src/Controllers/includes/configSession.inc.php";
        
        $_SESSION["userForgotId"] = serialize($this->userId);
        
        require_once "src/Views/recoverPassword.php";
        die();
    }
}

$recoverPasswordController = new RecoverPasswordController();
$recoverPasswordController->handleRequest();


