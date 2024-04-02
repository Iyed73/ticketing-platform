<?php 
require_once "..\..\src\Models\UserRepo.php";
class loginController {

    private $email;
    private $pwd;

    public function __construct($email, $pwd) {
        $this->email = $email;
        $this->pwd = $pwd;
    }
    
    public function sanitizeInput() {
        $this->email = htmlspecialchars($this->email);
        $this->pwd = htmlspecialchars($this->pwd);
    }

    public function isInputEmpty() {
        return empty($this->email) || empty($this->pwd);
    }

    public function isUserInDB() {
        $userTable = new UserRepo();
        $user = $userTable->findByEmail($this->email);
        if($user) {
            return true;
        }
        return false;
    }


    public function isPasswordIncorrect() {
        $userTable = new UserRepo();
        $user = $userTable->findByEmail($this->email);
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

    public function getUser(){
        $userTable = new UserRepo();
        $user = $userTable->findByEmail($this->email);
        return $user;
    }

    public function handleLoginForm() {
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

        require_once("C:\\xampp\htdocs\\ticketing-platform\src\Controllers\includes\configSession.inc.php");

        // Other error handling can be added here

        if (!empty($errors)) {
            $_SESSION["login_errors"] = $errors;
            header("Location: /ticketing-platform/home?login=failed");
            die();
        }

        // If there are no errors, log in the user
        $user = $this->getUser();
        $_SESSION["user_id"] = $user->id;
        $_SESSION["email"] = $user->email;
        $_SESSION["role"] = $user->role;
        
        // Create a new session id and append the user id to it for better security and association of data with the user for a personalized experience
        regenerate_session_id_loggedin();

        header("Location: /ticketing-platform/home?login=success");
        die();
    }
}