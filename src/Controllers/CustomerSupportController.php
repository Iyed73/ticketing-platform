<?php

require_once "src\Models\FormSubmissionsRepo.php";
require_once "src\Controllers\includes\configSession.inc.php";

$role = isset($_SESSION['role']) ? $_SESSION['role'] : null;
class CustomerSupportController {

    public $contactForms;
    public $contactFormTable;

    public function __construct() {
        $this->contactFormTable= new FormSubmissionsRepo();
    }
    
    public function getData(){
        $this->contactForms = $this->contactFormTable->findAll();
    }
    
    public function handleRequest(){
        $this->getData();
        require_once "src\Controllers\includes\configSession.inc.php";
        $_SESSION["contactForms"] = serialize($this->contactForms);
        require_once "src\Views\customerSupport.php";
        die();
    }
}
if ($role != 'admin') {
    $prefix = $_ENV['prefix'];
    header("Location: {$prefix}/home");
    exit;
}
$customerSupportController = new CustomerSupportController();
$customerSupportController->handleRequest();


