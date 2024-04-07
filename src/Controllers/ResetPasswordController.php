<?php
require_once "src\Models\UserRepo.php";
require_once "Services\StatelessTokenService.php";

/**
 This class is responsible for handling the request to reset the password and verifying the jwt.
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


    //returns user id if successful
    private function validateJWT($token){
        try {
            $JWT = new JwtService();
            $payload = $JWT->getPayload($token);

            if(!isset($payload)
             || !isset($payload["userId"])
             || !isset($payload["expiresAt"])
                ) {
                throw new Exception();
            }

            $userId = $this->sanitize($payload["userId"]);
            
            $this->userTable->findById($userId);

            if(!$this->userTable->exists($userId)) {
                throw new Exception();
            }

            $oldPasswordHash = $this->userTable->getOldPasswordHash($userId);
            
            if(!$oldPasswordHash || !$JWT->validateSignature($token, $oldPasswordHash->pwd)) {
                throw new Exception();
            }

            //from here, the signature is valid, so we can trust the payload
            
            if($payload["expiresAt"] < time() || $payload["type"] !== 'forgot_password') {
                throw new Exception();
            }

            return $payload["userId"];
        } catch (Exception $e) {
            require_once "src/Views/invalidToken.php";
            die();  
        }

    }
    
    private function getData(){
        $prefix = $_ENV['prefix'];
        if(!isset($_GET['token']) || !isset($_POST['newPassword']) || !isset($_POST['newPasswordConfirm'])){
            header("Location: {$prefix}/");
            die();
        }

        $token = $this->sanitize($_GET['token']);
        
        
        $newPassword = $this->sanitize($_POST['newPassword']);
        $newPasswordConfirm = $this->sanitize($_POST['newPasswordConfirm']);
        
        if($newPassword !== $newPasswordConfirm){
            require_once "src/Views/passwordMismatch.php";
            die();
        }

        $this->userId = $this->validateJWT($token);

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


