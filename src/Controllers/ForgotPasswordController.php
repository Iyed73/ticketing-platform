<?php
require_once "src\Models\UserRepo.php";
require_once "src\Models\TokenRepo.php";
require_once "Services\MailingService.php";

class ForgotPasswordController {
    private $userTable;
    private $tokenTable;
    private $user;
    private $token;
    private $email;
    private $recoveryLink;

    public function __construct() {
        $this->userTable = new UserRepo();
        $this->tokenTable = new TokenRepo();
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
        //if user does not exist or the user has no token or the token has expired, show the email form
        if(!$this->user){
            require_once "src/Views/forgotPassword.php";
            die();
        }
        
        $this->token = $this->tokenTable->findByUserIdAndType($this->user->id, 'forgot_password');
        
        if($this->token && strtotime($this->token->expires_at) >= time()){
            require_once "src/Views/forgotPassword.php";
            die();
        }
        
        //if token exists and has expired, delete the token
        if($this->token){
            $this->tokenTable->deleteByToken($this->token->token);
        }
        
        $token = bin2hex(random_bytes(16));
        $this->recoveryLink = "localhost{$prefix}/recoverPassword?token={$token}";
        
        //else, create a new token and send a recovery link to user's email
        $this->token = $this->tokenTable->insert([
            'user_id' => $this->user->id,
            'token' =>  $token,
            'type' => 'forgot_password',
            'expires_at' => date('Y-m-d H:i:s', strtotime('+1 hour'))
        ]);

        /*TODO: Mail works, link is broken*/
        // if(!$this->token || !sendMail($this->user->firstname,"Tickety", $this->email, '[Password Recovery]', $this->htmlMessage(), $this->textMessage())) {
        //    $response = "An error occurred, please try again!";
        // }

        require_once "src/Views/forgotPassword.php";
        die();
    }
}

$forgotPasswordController = new ForgotPasswordController();
$forgotPasswordController->handleRequest();


