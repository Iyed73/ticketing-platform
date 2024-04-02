<?php
/* require_once "Services\MailingService.php";
 */
require_once "src\Models\FormSubmissionsRepo.php";
require_once "src\Controllers\includes\configSession.inc.php";

$role = isset($_SESSION['role']) ? $_SESSION['role'] : null;
class ContactFormController
{
    private $name;
    private $subject;
    private $message;

    public function __construct($name, $subject, $message)
    {
        $this->name = $name;
        $this->subject = $subject;
        $this->message = $message;

    }

    public function sanitizeInput()
    {
        $this->name = htmlspecialchars($this->name);
        $this->subject = htmlspecialchars($this->subject);
        $this->message = htmlspecialchars($this->message);
    }

    public function is_input_empty()
    {
        return ((empty($this->name)) || (empty($this->subject)) || (empty($this->message)));
    }

    public function handleRequest()
    {
        if ($this->is_input_empty()) {
            return "Please fill all the fields";
        } else {
            $this->sanitizeInput();
            //sending email to the website 
            $email = "tickety873@gmail.com";
            /*             sendMail($this->name,"Tickety", $email, $this->subject, $this->message, $this->message);
             */
            //inserting the form submission into the database
            $date = date('Y-m-d H:i:s');
            $formSubmissionsTable = new FormSubmissionsRepo();
            $Data = [
                'name' => $this->name,
                'subject' => $this->subject,
                'message' => $this->message,
                'date' => $date
            ];
            $formSubmissionsTable->insert($Data);
            return "Message sent successfully";
        }
    }

}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $date = date('Y-m-d H:i:s');
    $contactFormController = new ContactFormController($_POST['name'], $_POST['subject'], $_POST['message']);
    $response = $contactFormController->handleRequest();
}
if ($role == 'admin') {
    header("Location: /ticketing-platform/home");
    exit;
} else {
    require_once "src\Views\contactForm.php";
}
