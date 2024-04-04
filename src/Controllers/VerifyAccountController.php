<?php
require_once "src\Models\UserRepo.php";
require_once "src\Models\TokenRepo.php";
require_once "Services/DecodableToken.php";
require_once("src\Controllers\includes\configSession.inc.php");

/**
 This class is responsible for handling the request to reset the password.
 */

class VerifyAccountController {
    private $userTable;
    private $tokenTable;
    private $user;
    private $token;

    public function __construct() {
        $this->userTable = new UserRepo();
        $this->tokenTable = new TokenRepo();
    }
    
    private function sanitize($input){
        return htmlspecialchars(stripslashes(trim($input)));
    }

    private function isTokenInvalid() {
        return !$this->token || $this->token->type !== 'account_verification';
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

        $userId = decode_token($this->token->token, $_ENV['SECRET_KEY']);
        $this->user = $this->userTable->findById($userId);
    }
    
    public function handleRequest(){
        $prefix = $_ENV['prefix'];
        $this->getData();
        
        $this->userTable->verifyUser($this->user->id);

        $this->tokenTable->deleteByToken($this->token->token);

        require_once "src/Views/accountVerified.php";
        die();
    }
}

$verifyAccountController = new VerifyAccountController();
$verifyAccountController->handleRequest();


