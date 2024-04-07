<?php
require_once "src\Models\UserRepo.php";

class ChangeAccountInfoController{
    private $userTable;
    private $newFirstName;
    private $newLastName;

    public function __construct($newFirstName = null, $newLastName= null){
        $this->newFirstName = $newFirstName;
        $this->newLastName = $newLastName;
        $this->userTable = new UserRepo();
    }

    public function sanitizeInput(){
        $this->newFirstName = htmlspecialchars($this->newFirstName);
        $this->newLastName = htmlspecialchars($this->newLastName);
    }

    public function is_input_empty(){
        return ((empty($this->newFirstName)) && (empty($this->newLastName)));
    }

    public function handleRequest(){
        $this->sanitizeInput();
        //ERROR HANDLING
        if($this->is_input_empty()){
            $errors = [
                "empty_input" => "nothing to update!",
            ];
            $_SESSION["errors"] = $errors;
        }
        else{
            //UPDATE FIRST NAME
            if(!empty($this->newFirstName)){
                try{
                    $this->userTable->updateFirstName($_SESSION["user_id"], $this->newFirstName);
                }catch (Exception $e) {
                    http_response_code(500);
                    die();
                }   
            }
            //UPDATE LAST NAME
            if(!empty($this->newLastName)){
                try{
                    $this->userTable->updateLastName($_SESSION["user_id"], $this->newLastName);
                }catch (Exception $e) {
                    http_response_code(500);
                    die();
                }
            }
        }
    }

    public function loadPage(){
        $prefix = $_ENV['prefix'];
        $user = $this->userTable->findById($_SESSION["user_id"]);
        $_SESSION["firstName"] = $user->firstname;
        $_SESSION["lastName"] = $user->lastname;
        include "src\Views\userProfile.php";
    }
}

if(isset($_SESSION["user_id"])){
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $changeAccountInfoController = new ChangeAccountInfoController($_POST["firstname"], $_POST["lastname"]);
        $changeAccountInfoController->handleRequest();
    }
    $loader = new ChangeAccountInfoController();
    $loader->loadPage();
}
else{
    $prefix = $_ENV['prefix'];
    header("Location: {$prefix}/home"); 
}

