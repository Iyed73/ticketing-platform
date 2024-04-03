<?php
require_once ("src\Models\UserRepo.php");
require_once ("src\Models\TokenRepo.php");
require_once ("Services\MailingService.php");
require_once ("Services\DecodableToken.php");


class SignupController
{
    private $firstName;
    private $lastName;
    private $email;
    private $pwd;
    private $userTable;
    private $tokenTable;
    private $token;
    private $user;
    private $verificationUrl;

    public function __construct($firstName, $lastName, $email, $pwd)
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->pwd = $pwd;
        $this->userTable = new UserRepo();
        $this->tokenTable = new TokenRepo();
    }

    public function sanitizeInput()
    {
        $this->firstName = htmlspecialchars($this->firstName);
        $this->lastName = htmlspecialchars($this->lastName);
        $this->email = htmlspecialchars($this->email);
        $this->pwd = htmlspecialchars($this->pwd);
    }

    public function is_input_empty()
    {
        return ((empty($this->firstName)) || (empty($this->lastName)) || (empty($this->email)) || (empty($this->pwd)));
    }

    public function is_email_invalid()
    {
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            return true;
        }
        return false;
    }

    public function is_email_taken()
    {
        $user = $this->userTable->findByEmail($this->email);
        if ($user) {
            return true;
        }
        return false;
    }

    public function addCustomer()
    {
        //Hashing the password
        $options = [
            'cost' => 12   //recommended value berween 10 and 12 (the higher the cost the more complex the hashing is the more time it will take a user to log in but better for security.
        ];
        $hashedPwd = password_hash($this->pwd, PASSWORD_BCRYPT, $options);  //you can you PASSWORD_DEFAULT so that it automatically updates if user updates hashing methode. other options(PASSWORD_ARGON2I || PASSWORD_ARGON2ID winner of a password hashing competition)

        $this->userTable->insert([
            'firstname' => $this->firstName,
            'lastname' => $this->lastName,
            'email' => $this->email,
            'pwd' => $hashedPwd
        ]);

        return $this->userTable->findByEmail($this->email);
    }

    private function htmlMessage($name, $url)
    {
        return "<h2>Welcome to Tickety!</h2><p>Dear {$name}, <br><br>Thank you for signing up to Tickety! We are excited to have you on board.<br><br> Please click the link below to verify your account: <br><a href={$url}>Verify  My Account</a><br><br>Best Regards, <br>Tickety Team</p>";
    }

    private function textMessage($name, $url)
    {
        return "Welcome to Tickety!\n\nDear {$name}, \n\nThank you for signing up to Tickety! We are excited to have you on board.\n\nPlease click the link below to verify your account:\n{$url}\n\nBest Regards, \nTickety Team";
    }


    

    public function handleSignupForm()
    {
        $this->sanitizeInput();


        //ERROR HANDLING
        $errors = [];
        if (empty($errors) && $this->is_input_empty()) {
            $errors["empty_input"] = "Fill in all fields!";
        }
        if (empty($errors) && $this->is_email_invalid()) {
            $errors["invalid_email"] = "Invalid email!";
        }
        if (empty($errors) && $this->is_email_taken()) {
            $errors["email_taken"] = "Email already taken!";
        }

        //If there are no errors, create a new user
        if (empty($errors)) {
            $this->user = $this->addCustomer();
        }

        if (empty($errors) && !$this->user) {
            $errors["server_error"] = "No user";
        }
        
        //we need this token to be decodable to use it to encode the user id,
        //this enables users to verify their account even when they are not logged in
        $token = generate_token($this->user->id, $_ENV['SECRET_KEY']);

        if (empty($errors)) {
            $this->tokenTable->insert([
                'user_id' => $this->user->id,
                'token' => $token,
                'type' => 'account_verification',
                'expires_at' => '2038-01-19 03:14:07' //largest possible timestamp for 32-bit systems, we want a token that doesn't expire
            ]);

            $this->token = $this->tokenTable->findByToken($token);
        }

        if (empty($errors) && !$this->token) {
            $errors["server_error"] = "Server error, please try again.";
            if ($this->user) {
                $this->userTable->deleteById($this->user->id);
            }
        }

        $prefix = $_ENV['prefix'];
        $this->verificationUrl = "http://localhost{$prefix}/verify?token={$token}";

        /*TODO: Works, uncomment later */
        // if (
        //     !sendMail(
        //         "Tickety",
        //         $this->firstName,
        //         $this->email,
        //         "Welcome to Tickety - [Account Verification]",
        //         $this->htmlMessage($this->firstName, $this->verificationUrl),
        //         $this->textMessage($this->firstName, $this->verificationUrl)
        //     )
        // ) {
        //     $errors["server_error"] = "Server error, please try again.";
        //     if ($this->token) {
        //         $this->tokenTable->deleteByToken($this->token->token);
        //     }
        //     if ($this->user) {
        //         $this->userTable->deleteById($this->user->id);
        //     }
        // }


        //other error handling can be added here


        require_once ("src\Controllers\includes\configSession.inc.php");

        if (!empty($errors)) {
            $_SESSION["signup_errors"] = $errors;

            $signupData = [
                "firstname" => $this->firstName,
                "lastname" => $this->lastName,
                "email" => $this->email
            ];
            $_SESSION["signup_data"] = $signupData;
            $prefix = $_ENV['prefix'];
            header("Location: {$prefix}/home?signup=failed");
        } else {
            $prefix = $_ENV['prefix'];
            header("Location: {$prefix}/home?signup=success");
        }
        die();
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $signupcontroller = new signupController($_POST["firstname"], $_POST["lastname"], $_POST["email"], $_POST["password"]);
    $signupcontroller->handleSignupForm();
} else {
    $prefix = $_ENV['prefix'];
    header("Location: {$prefix}/home?notpost");
    die();
}
