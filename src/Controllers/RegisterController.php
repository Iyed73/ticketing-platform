<?php
require_once("src\Models\UserRepo.php");
require_once("Services\MailingService.php");
include 'prefix.php';
class SignupController {
    private $firstName;
    private $lastName;
    private $email;
    private $pwd;
    private $userTable;
    
    public function __construct($firstName, $lastName, $email, $pwd) {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->pwd = $pwd;
        $this->userTable = new UserRepo();
    }
    
    public function sanitizeInput() {
        $this->firstName = htmlspecialchars($this->firstName);
        $this->lastName = htmlspecialchars($this->lastName);
        $this->email = htmlspecialchars($this->email);
        $this->pwd = htmlspecialchars($this->pwd);
    }
    
    public function is_input_empty() {
        return((empty($this->firstName))||(empty($this->lastName))||(empty($this->email))||(empty($this->pwd)));
    }

    public function is_email_invalid() {
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            return true;
        }
        return false;
    }

    public function is_email_taken() {
        $user = $this->userTable->findByEmail($this->email);
        if($user) {
            return true;
        }
        return false;
    }

    public function addCustomer() {        
        //Hashing the password
        $options = [
            'cost' => 12   //recommended value berween 10 and 12 (the higher the cost the more complex the hashing is the more time it will take a user to log in but better for security.
        ];
        $hashedPwd = password_hash($this->pwd, PASSWORD_BCRYPT,$options);  //you can you PASSWORD_DEFAULT so that it automatically updates if user updates hashing methode. other options(PASSWORD_ARGON2I || PASSWORD_ARGON2ID winner of a password hashing competition)

        $this->userTable->insert([
            'firstname' => $this->firstName,
            'lastname' => $this->lastName,
            'email' => $this->email,
            'pwd' => $hashedPwd
        ]);
    }

    public function handleSignupForm($prefix) {
        $this->sanitizeInput();

        //ERROR HANDLING
        $errors = [];
        if ($this->is_input_empty()) {
            $errors["empty_input"] = "Fill in all fields!";
        }
        if ($this->is_email_invalid()) {
            $errors["invalid_email"] = "Invalid email!";
        }
        if ($this->is_email_taken()) {
            $errors["email_taken"] = "Email already taken!";
        }
        //other error handling can be added here

        require_once ("src\Controllers\includes\configSession.inc.php");

        if ($errors) {
            $_SESSION["signup_errors"] = $errors;

            $signupData = [
                "firstname" => $this->firstName,
                "lastname" => $this->lastName,
                "email" => $this->email
            ];
            $_SESSION["signup_data"] = $signupData;
            include 'prefix.php';
            header("Location: {$prefix}/home?signup=failed");
            die();
        }
        //If there are no errors, create a new user
        $this->addCustomer();
        sendMail("Tickety",$this->firstName,$this->email,"Welcome to Tickety",generateSingUpMessageHtml($this->firstName),generateSignUpMessageText($this->firstName));
        include 'prefix.php';
        header("Location: {$prefix}/home?signup=success");
        die();
    } 
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $signupcontroller = new signupController($_POST["firstname"], $_POST["lastname"], $_POST["email"], $_POST["password"]);
    $signupcontroller->handleSignupForm($prefix);
} else {
    header("Location: {$prefix}/home?notpost");
    die();
}
