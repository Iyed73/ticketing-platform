<?php 
require_once("../Models/UserRepo.php");
class loginController {
    private $username;
    private $pwd;

    public function __construct($username, $pwd) {
        $this->username = $username;
        $this->pwd = $pwd;
    }
    
    public function sanitizeInput() {
        $this->username = htmlspecialchars($this->username);
        $this->pwd = htmlspecialchars($this->pwd);
    }

    public function is_input_empty() {
        return((empty($this->username))||(empty($this->pwd)));
    }

    public function is_user_in_db() {
        $userTable = new UserRepo();
        $user = $userTable->findByusername($this->username);
        if($user) {
            return true;
        }
        return false;
    }

    public function is_password_incorrect() {
        $userTable = new UserRepo();
        $user = $userTable->findByusername($this->username);
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
        $user = $userTable->findByusername($this->username);
        return $user;
    }
}