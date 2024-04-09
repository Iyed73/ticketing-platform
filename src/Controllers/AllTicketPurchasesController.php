<?php

require_once("src/Models/UserRepo.php");
require_once("src/Models/TicketManagementModel.php");

class AllTicketPurchasesController {
    private TicketManagementModel $ticketManagementModel;
    public function __construct() {
        $this->ticketManagementModel = new TicketManagementModel();
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
        $allTickets = $this->ticketManagementModel->findWithOffset($offset, 5);

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
