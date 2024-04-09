<?php 
require_once "src/Models/UserRepo.php";
class ChangePasswordController
{
    private $userTable;
    private $oldpassword;
    private $newpassword;
    private $confirmpassword;

    public function __construct($oldpassword, $newpassword, $confirmpassword)
    {
        $this->oldpassword = $oldpassword;
        $this->newpassword = $newpassword;
        $this->confirmpassword = $confirmpassword;
        $this->userTable = new UserRepo();
    }

    public function sanitizeInput()
    {
        $this->oldpassword = htmlspecialchars($this->oldpassword);
        $this->newpassword = htmlspecialchars($this->newpassword);
        $this->confirmpassword = htmlspecialchars($this->confirmpassword);
    }

    public function is_input_empty()
    {
        return ((empty($this->oldpassword)) || (empty($this->newpassword)) || (empty($this->confirmpassword)));
    }

    public function is_old_password_correct()
    {
        $user = $this->userTable->findById($_SESSION["user_id"]);
        if (password_verify($this->oldpassword, $user->pwd)) {
            return true;
        }
        return false;
    }

    public function is_comfirmed_password_correct()
    {
        return ($this->newpassword === $this->confirmpassword);
    }

    public function handleRequest()
    {
        $prefix = $_ENV['prefix'];
        $this->sanitizeInput();
        //ERROR HANDLING
        $errors = [];
        if ($this->is_input_empty()) {
            $errors["empty_input"]= "empty input!";
        } 
        if (!$this->is_old_password_correct()) {
            $errors["old_password_incorrect"] = "old password is incorrect!";
        }
        if (!$this->is_comfirmed_password_correct()) {
            $errors["password_mismatch"] = "passwords do not match!";
        }
        if (!empty($errors)) {
            $_SESSION["change_pwd_errors"] = $errors;
        } 
        else {
            $options = [
                'cost' => 12   //recommended value berween 10 and 12 (the higher the cost the more complex the hashing is the more time it will take a user to log in but better for security.
            ];
            $password = password_hash($this->newpassword, PASSWORD_BCRYPT, $options);
            try {
                $this->userTable->updatePassword($_SESSION["user_id"], $password);
                $_SESSION["change_pwd_success"] = "true";
            } catch (Exception $e) {
                http_response_code(500);
                die();
            }
        }
        header("Location: {$prefix}/userProfile?tab=security");
    }
}

if(isset($_SESSION["user_id"])){
    if($_SERVER["REQUEST_METHOD"] === "POST"){
        $changePasswordController = new ChangePasswordController($_POST["currentpassword"], $_POST["newpassword"], $_POST["confirmpassword"]);
        $changePasswordController->handleRequest();
    }
    else{
        $prefix = $_ENV['prefix'];
        header("Location: {$prefix}/userProfile");
    }
}
else{
    header("Location: {$prefix}/home");
    die();
}