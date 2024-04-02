<?php

require_once "src\Models\FormSubmissionsRepo.php";

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
        require_once "includes/configSession.inc.php";
        $_SESSION["contactForms"] = serialize($this->contactForms);
        require_once "src\Views\customerSupport.php";
        die();
    }
}

$customerSupportController = new CustomerSupportController();
$customerSupportController->handleRequest();


