<?php
require_once "src\Models\TicketManagementModel.php";
require_once "Services\TicketGenerator.php";


class TicketPDFController {
    private $ticketModel;

    public function __construct() {
        $this->ticketModel = new TicketManagementModel();

    }

    public function handleRequest() {
        if (!isset($_GET['ticket_id'], $_GET['action'], $_GET['event_name'], $_GET['event_date'], $_GET['venue'], $_GET['purchase_date'], $_GET['buyer_name'], $_GET['ticket_holder_name'], $_GET['buyer_id'])) {
            http_response_code(400);
            exit();
        }
        // todo: if user is admin, skip this bloc
        if ($_GET['buyer_id'] != $_SESSION['user_id']) {
            http_response_code(403);
            exit();
        }
        if (!$this->ticketModel->isTicketValidForUser($_GET['ticket_id'], $_GET['buyer_id'])) {
            http_response_code(400);
            exit();
        }

        $ticketInfo = [
            'ticketId' => $_GET['ticket_id'],
            'eventName' => $_GET['event_name'],
            'eventDate' => $_GET['event_date'],
            'eventVenue' => $_GET['venue'],
            'purchaseDate' => $_GET['purchase_date'],
            'buyerName' => $_GET['buyer_name'],
            'ticketHolderName' => $_GET['ticket_holder_name'],
            'buyerId' => $_GET['buyer_id']
        ];

        $action = $_GET['action'];
        generateTicket($ticketInfo, $action);



    }
}

session_start();
if (!isset($_SESSION["user_id"])) {
    http_response_code(401);
    exit();
}

$ticketPDFController = new TicketPDFController();
$ticketPDFController->handleRequest();
