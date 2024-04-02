<?php 
require_once "Services\MailingService.php";

class ContactFormController{
    private $name;
    private $subject;
    private $message;

    public function __construct($name, $subject, $message) {
        $this->name = $name;
        $this->subject = $subject;
        $this->message = $message;

    }
    
    public function sanitizeInput() {
        $this->name = htmlspecialchars($this->name);
        $this->subject = htmlspecialchars($this->subject);
        $this->message = htmlspecialchars($this->message);
    }

    public function is_input_empty() {
        return((empty($this->name))||(empty($this->subject))||(empty($this->message)));
    }

    public function handleRequest() {
        if($this->is_input_empty()) {
            return "Please fill all the fields";
        }
        else {
            $this->sanitizeInput();
            $email = "tickety873@gmail.com";
            sendMail($this->name,"Tickety", $email, $this->subject, $this->message, $this->message);
            return "Message sent successfully";
        }
    }

}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $subject = $_POST["subject"];
    $message = $_POST["message"];
    $date = date('Y-m-d H:i:s');

    $controller = new ContactFormController($name, $subject, $message);
    /* $response = $controller->handleRequest(); */
    
    try {
        require_once "src\Models\FormSubmissionsRepo.php";
        
        $formSubmissionsRepo = new FormSubmissionsRepo();
        $formSubmissionsRepo->insertFormSubmission($name, $subject, $message, $date);

        header("Location: /ticketing-platform/contact?mailsend");
        die("query successful");
    } catch (PDOException $e) {
        die("query failed: " . $e->getMessage());
    }
}

require_once "src\Views\contactForm.php";