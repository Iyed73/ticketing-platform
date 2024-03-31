<?php 
require_once("../Models/UserRepo.php");
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
}