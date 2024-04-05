<?php
require_once "src\Models\UserRepo.php";
require_once "Services\MailingService.php";
require_once "Services\StatelessTokenService.php";
$MAIL_RATE_LIMIT = 60*30; // 30 minutes
$JWT_EXPIRATION_TIME = 60*30; // 30 minutes

/**
 This class is responsible for creating the token, the recovery link and the mail sent to the user's email.
 */

class ForgotPasswordController {
    private $userTable;
    private $user;
    private $token;
    private $email;
    private $recoveryLink;

    public function __construct() {
        $this->userTable = new UserRepo();
    }
    
    private function sanitizeInput()
    {
        $this->email = htmlspecialchars($this->email);
    }

    private function isInputEmpty()
    {
        return empty($this->email);
    }

    private function htmlMessage() {
        return "<h2>Password Recovery Link:</h2><p>Dear {$this->user->firstname}, <br><br>Please click the link below to recover your password:<br><br><a href={$this->recoveryLink}>Reset Password</a><br><br>If you didn't request this, please ignore this email.<br>Best Regards, <br>Tickety Team</p>";
    } 

    private function textMessage() {
        return "Password Recovery Link:\n\nDear {$this->user->firstname},\n\nPlease click the link below to recover your password:\n\n{$this->recoveryLink}\n\nIf you didn't request this, please ignore this email.\n\nBest Regards,\nTickety Team";
    }
    
    

    public function handleRequest(){
        $prefix = $_ENV['prefix'];
        if(!isset($_POST['email'])){
            require_once "src/Views/forgotPassword.php";
            die();
        } 
        
        $this->email = $_POST['email'];
        $this->sanitizeInput();
        
        //if email is empty, unauthorized access
        if($this->isInputEmpty()){
            http_response_code(401);
            die();
        }
        
        $this->user = $this->userTable->findByEmail($this->email);
        
        $response = "An email has been sent, please check your inbox!";
        
        //if user does not exist or is rate limited show the email form
        if(!$this->user){
            require_once "src/Views/forgotPassword.php";
            die();
        }
        
        //the comparison is offset by an hour due to a mismatch between the epoch time of php and the db
        //even though they're both using the same timezone
        //?????????

        if($this->user->last_recovery_token_sent_at 
        && ((time() - strtotime($this->user->last_recovery_token_sent_at) - 3600) < $GLOBALS["MAIL_RATE_LIMIT"])){
            $response = "You've tried too many times, please try again later!";
            require_once "src/Views/forgotPassword.php";
            die();
        }
        
        
        $JWT = new JwtService();
        $payload = [
            'userId' => $this->user->id,
            'type' => 'forgot_password',
            'expiresAt' => (time() + $GLOBALS["JWT_EXPIRATION_TIME"])
        ];
        
        $oldPasswordHash = $this->userTable->getOldPasswordHash($this->user->id);

        if(!$oldPasswordHash) {
            $response = "An error occurred, please try again!";
            require_once "src/Views/forgotPassword.php";
            die();
        }


        $this->token = $JWT->encode($payload, $oldPasswordHash->pwd);

        $this->recoveryLink = "http://localhost{$prefix}/recoverPassword?token={$this->token}";
        
        if(!sendMail($this->user->firstname,"Tickety", $this->email, '[Password Recovery]', $this->htmlMessage(), $this->textMessage())) {
           $response = "An error occurred, please try again!";
        } else {
            $this->userTable->updateLastTokenSent($this->user->id);
        }

        
        require_once "src/Views/forgotPassword.php";
        die();
    }
}

$forgotPasswordController = new ForgotPasswordController();
$forgotPasswordController->handleRequest();


