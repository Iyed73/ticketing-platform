<?php
require_once "src\Controllers\includes\configSession.inc.php";
require_once "src\Models\UserRepo.php";

class ChangeAccountInfoController{
    private $userRepo;
    private $newFirstName;
    private $newLastName;

    public function __construct($newFirstName, $newLastName){
        $this->newFirstName = $newFirstName;
        $this->newLastName = $newLastName;
        $this->userRepo = new UserRepo();
    }

    public function sanitizeInput(){
        $this->newFirstName = htmlspecialchars($this->newFirstName);
        $this->newLastName = htmlspecialchars($this->newLastName);
    }

    public function is_input_empty(){
        return ((empty($this->newFirstName)) && (empty($this->newLastName)));
    }

    public function handleRequest(){
        $prefix = $_ENV['prefix'];
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
                    $this->userRepo->updateFirstName($_SESSION["user_id"], $this->newFirstName);
                }catch (Exception $e) {
                    http_response_code(500);
                    die();
                }   
            }
            //UPDATE LAST NAME
            if(!empty($this->newLastName)){
                try{
                    $this->userRepo->updateLastName($_SESSION["user_id"], $this->newLastName);
                }catch (Exception $e) {
                    http_response_code(500);
                    die();
                }
            }
        }
        include "src/Views/ChangeAccountInfoView.php";
    }
}

if(isset($_SESSION["user_id"])){
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $changeAccountInfoController = new ChangeAccountInfoController($_POST["newFirstName"], $_POST["newLastName"]);
        $changeAccountInfoController->handleRequest();
    }
    else{
        include "src/Views/ChangeAccountInfoView.php";
    }
}
else{
    header("Location: {$prefix}/home"); //change url to the page where the form is later
}

