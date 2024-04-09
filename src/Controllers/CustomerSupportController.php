<?php

require_once "src\Models\FormSubmissionsRepo.php";
require_once "src\Controllers\includes\configSession.inc.php";

$role = isset($_SESSION['role']) ? $_SESSION['role'] : null;
class CustomerSupportController
{

    private $contactForms;
    private FormSubmissionsRepo $contactFormTable;

    public function __construct()
    {
        $this->contactFormTable = new FormSubmissionsRepo();
    }

    public function handleRequest()
    {
        $maxPerPage = 10;
        $totalPages = $this->contactFormTable->totalPagesNum($maxPerPage);
        $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
        $offset = ($currentPage - 1) * $maxPerPage;
        $contactForms = $this->contactFormTable->findWithOffset($offset, $maxPerPage);

        if ($contactForms == null) {
            $contactForms = [];
        }
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


