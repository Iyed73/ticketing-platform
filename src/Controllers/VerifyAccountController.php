<?php
require_once "src\Models\UserRepo.php";
require_once "Services/StatelessTokenService.php";
require_once("src\Controllers\includes\configSession.inc.php");

/**
 This class is responsible for handling the request to reset the password.
 */

class VerifyAccountController {
    private $userTable;
    private $user;
    private $token;

    public function __construct() {
        $this->userTable = new UserRepo();
    }
    
    private function sanitize($input){
        return htmlspecialchars(stripslashes(trim($input)));
    }

    private function isTokenInvalid() {
        return !$this->token 
        || $this->token["type"] !== 'account_verification' 
        || !$this->user
        || $this->user->is_verified;
    }
    

    private function getData(){
        $prefix = $_ENV['prefix'];
        if(!isset($_GET['token'])){
            header("Location: {$prefix}/");
            die();
        }

        $this->token = $this->sanitize($_GET['token']);

        try {
            $JWT = new JwtService();
            $this->token = $JWT->decode($this->token, $_ENV['SECRET_KEY']);
        } catch (Exception $e) {
            require_once "src/Views/invalidToken.php";
            die();  
        }

    
        $this->user = $this->userTable->findById($this->token["userId"]);
    }
    
    public function handleRequest(){
        $this->getData();

        if($this->isTokenInvalid()){
            require_once "src/Views/invalidToken.php";
            die();
        }
        
        if(!$this->userTable->verifyUser($this->user->id)) {
            http_response_code(500);
            die();
        }

        require_once "src/Views/accountVerified.php";
        die();
    }
}

$verifyAccountController = new VerifyAccountController();
$verifyAccountController->handleRequest();


