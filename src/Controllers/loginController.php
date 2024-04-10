<?php 
require_once 'Services\rememberMeService.php';

class loginController {
    private $email;
    private $pwd;
    private $userTable;

    public function __construct($email, $pwd) {
        $this->email = $email;
        $this->pwd = $pwd;
        $this->userTable = new UserModel();
    }
    
    public function sanitizeInput() {
        $this->email = htmlspecialchars($this->email);
        $this->pwd = htmlspecialchars($this->pwd);
    }

    public function isInputEmpty() {
        return empty($this->email) || empty($this->pwd);
    }

    public function isUserInDB() {
        $user = $this->userTable->findByEmail($this->email);
        if($user) {
            return true;
        }
        return false;
    }

    public function isPasswordIncorrect() {
        $user = $this->userTable->findByEmail($this->email);
        if(!empty($user)){
            if(password_verify($this->pwd, $user->pwd)) {
                return false;
            }
            else{
                return true;
            }
        }
        return true;
    }

    public function isUserLoggedIn(){
        if(isset($_SESSION["user_id"])&&isset($_SESSION["role"])){
            return true;
        }
        return false;
    }

    public function getUser(){
        $user = $this->userTable->findByEmail($this->email);
        return $user;
    }

    public function handleLoginForm($prefix) {
        $prefix = $_ENV['prefix'];
        //check if the user is already logged in for security reasons
        if($this->isUserLoggedIn()){
            header("Location: {$prefix}/home?alreadyloggedin");
            die();
        }
        //else continue with the login process
        $this->sanitizeInput();
        // ERROR HANDLING
        $errors = [];
        if ($this->isInputEmpty()) {
            $errors["empty_input"] = "Fill in all fields!";
        }
        if (!$this->isUserInDB()) {
            $errors["user_not_found"] = "User not found!";
        }
        if ($this->isUserInDB() && $this->isPasswordIncorrect()) {
            $errors["incorrect_password"] = "Incorrect password";
        }
        // Other error handling can be added here
        if (!empty($errors)) {
            $_SESSION["login_errors"] = $errors;
            $prefix = $_ENV['prefix'];
            header("Location: {$prefix}/home?login=failed");
            die();
        }

        // If there are no errors, log in the user
        $user = $this->getUser();
        $_SESSION["user_id"] = $user->id;
        $_SESSION["email"] = $user->email;
        $_SESSION["role"] = $user->role;
        
        // Check if the the user chose to be remembered
        if(isset($_POST['remember_me'])) {
            $rememberMeService = new rememberMeService();
            $rememberMeService->rememberMe($user->id);
        }
        // Create a new session id and append the user id to it for better security and association of data with the user for a personalized experience
        regenerate_session_id_loggedin();
        header("Location: {$prefix}/home?login=success");
        die();
    }
}

//check if the request method is post
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $loginController = new loginController($_POST["email"], $_POST["password"]);
    $loginController->handleLoginForm($prefix);
} else {
    $prefix = $_ENV['prefix'];
    header("Location: {$prefix}/home?notpost");
    die();
}