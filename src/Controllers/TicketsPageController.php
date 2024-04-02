<?php
require_once "src\Models\UserRepo.php";
require_once "src\Models\TicketManagementModel.php";

class TicketsPageController {
    private $userRepo;
    private $ticketModel;

    public function __construct() {
        $this->userRepo = new UserRepo();
        $this->ticketModel = new TicketManagementModel();
    }

    public function handleRequest($userId) {
        $tickets = $this->ticketModel->getAllTickets($userId);


        require_once "src/Views/ticketsView.php";
    }
}

session_start();
if (!isset($_SESSION["user_id"])) {
    http_response_code(401);
    exit();
}

$manageTicketsController = new TicketsPageController();
$manageTicketsController->handleRequest($_SESSION["user_id"]);

