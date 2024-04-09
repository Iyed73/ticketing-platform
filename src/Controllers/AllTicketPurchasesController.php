<?php

require_once("src/Models/UserRepo.php");
require_once("src/Models/TicketManagementModel.php");
require_once 'Services\CurrencyConverter.php';


class AllTicketPurchasesController {
    private TicketManagementModel $ticketManagementModel;
    private CurrencyConverter $currencyConverter;
    public function __construct() {
        $this->ticketManagementModel = new TicketManagementModel();
        $this->currencyConverter = new CurrencyConverter();
    }


    public function handleRequest($userID) {

        $userRepo = new UserRepo();

        if (!$userRepo->isAdmin($userID)) {
            http_response_code(401);
            exit();
        }

        $ticketModel = $this -> ticketManagementModel;
        $totalPages = $this->ticketManagementModel->totalPagesNum();
        $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
        $offset = ($currentPage - 1) * 5;

        $allTickets = $this->ticketManagementModel->findTicketsDataWithOffset($offset, 5);

        if (isset($_SESSION['currency']) && $_SESSION['currency'] !== 'USD') {
            foreach ($allTickets as $ticket) {
                $ticket->price = $this->currencyConverter->convertPrice($ticket->price, $_SESSION['currency']);
            }
        }

        if($allTickets == null){
            $allTickets = [];
        }

        require_once "src/Views/Dashboard/AllTicketsPurchasesBoard.php";

    }
}

require_once "src/Controllers/includes/configSession.inc.php";

if (!isset($_SESSION["user_id"])) {
    http_response_code(401);
    exit();
} else {
    $allTicketPurchasesController = new AllTicketPurchasesController();
    $allTicketPurchasesController->handleRequest($_SESSION["user_id"]);
}
