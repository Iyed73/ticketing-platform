<?php
require_once("../Models/UserRepo.php");
class SignupController {
    private $firstName;
    private $lastName;
    private $username;
    private $email;
    private $pwd;
    
    public function __construct($firstName, $lastName, $username, $email, $pwd) {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->username = $username;
        $this->email = $email;
        $this->pwd = $pwd;
    }
    
    public function sanitizeInput() {
        $this->firstName = htmlspecialchars($this->firstName);
        $this->lastName = htmlspecialchars($this->lastName);
        $this->username = htmlspecialchars($this->username);
        $this->email = htmlspecialchars($this->email);
        $this->pwd = htmlspecialchars($this->pwd);
    }
    
    public function is_input_empty() {
        return((empty($this->firstName))||(empty($this->lastName))||(empty($this->username))||(empty($this->email))||(empty($this->pwd)));
    }

    public function is_email_invalid() {
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            return true;
        }
        return false;
    }

    public function is_username_taken() {
        $userTable = new UserRepo();
        $user = $userTable->findByUsername($this->username);
        if($user) {
            return true;
        }
        return false;
    }

    public function is_email_taken() {
        $userTable = new UserRepo();
        $user = $userTable->findByEmail($this->email);
        if($user) {
            return true;
        }
        return false;
    }

    public function createUser() {
        $userTable = new UserRepo();
        
        //Hashing the password
        $options = [
            'cost' => 12   //recommended value berween 10 and 12 (the higher the cost the more complex thehashing is the more time it will take a user to log in but better for security
        ];
        $hashedPwd = password_hash($this->pwd, PASSWORD_BCRYPT,$options);  //you can you PASSWORD_DEAULT so that it automatically updates if user updates hashing methode. other options(PASSWORD_ARGON2I || PASSWORD_ARGON2ID winner of a password hashing competition)

        $userTable->insert([
            'firstname' => $this->firstName,
            'lastname' => $this->lastName,
            'username' => $this->username,
            'email' => $this->email,
            'pwd' => $hashedPwd
        ]);
    }
}
