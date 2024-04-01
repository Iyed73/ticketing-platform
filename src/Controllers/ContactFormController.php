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
    $controller = new ContactFormController($name, $subject, $message);
    $response = $controller->handleRequest();
}
require_once "src\Views\contactPage\contactForm.php";