<?php
require_once "src\Models\TicketManagementModel.php";
require_once "Services/ticketGenerator.php";



class TicketPDFController {
    private TicketManagementModel $ticketModel;

    public function __construct() {
        $this->ticketModel = new TicketManagementModel();

    }

    public function handleRequest() {
        if (!isset($_GET['ticket_id'], $_GET['buyer_id'], $_GET['action'])) {
            http_response_code(400);
            exit();
        }
        $action = $_GET['action'];
        $ticketId = $_GET['ticket_id'];
        $buyerId = $_GET['buyer_id'];

        // todo: if user is admin, skip this bloc
        if ($buyerId != $_SESSION['user_id']) {
            http_response_code(403);
            exit();
        }

        if (!$this->ticketModel->isTicketValidForUser($ticketId, $buyerId)) {
            http_response_code(400);
            exit();
        }

        $ticketInfo = $this->ticketModel->getTicketInfo($ticketId, $buyerId);

        if (!$ticketInfo) {
            http_response_code(404);
            exit();
        }

        generateSingleTicket($ticketInfo, $action);



    }
}


if (!isset($_SESSION["user_id"])) {
    http_response_code(401);
    exit();
}

$ticketPDFController = new TicketPDFController();
$ticketPDFController->handleRequest();
