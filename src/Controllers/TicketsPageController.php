<?php

class TicketsPageController {
    private $UserModel;
    private $ticketModel;

    public function __construct() {
        $this->UserModel = new UserModel();
        $this->ticketModel = new TicketManagementModel();
    }

    public function handleRequest() {
        $userId = $_SESSION["user_id"];
        // todo: add check that user is not an admin
        $tickets = $this->ticketModel->getAllTickets($userId);


        require_once "src/Views/ticketsView.php";
    }
}

if (!isset($_SESSION["user_id"])) {
    http_response_code(401);
    exit();
}

$manageTicketsController = new TicketsPageController();
$manageTicketsController->handleRequest();

