<?php
require_once("src/Models/UserRepo.php");
require_once("src/Models/EventRepo.php");

class AllEventsBoardController {
    private UserRepo $userRepo;
    private EventRepo $eventRepo;
    public function __construct() {
        $this->userRepo = new UserRepo();
        $this->eventRepo = new EventRepo();
    }


    public function handleRequest($userID) {

        if (!$this->userRepo->isAdmin($userID)) {
            http_response_code(401);
            exit();
        }

        $totalPages = $this->eventRepo->totalPagesNum();
        $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
        $offset = ($currentPage - 1) * 5;
        $allEvents = $this->eventRepo->findWithOffset($offset, 5);

        if($allEvents == null){
            $allEvents = [];
        }

        require_once "src/Views/Dashboard/AllEventsBoard.php";

    }
}

require_once "src/Controllers/includes/configSession.inc.php";

if (!isset($_SESSION["user_id"])) {
    http_response_code(401);
    exit();
} else {
    $allEventsBoardController = new AllEventsBoardController();
    $allEventsBoardController->handleRequest($_SESSION["user_id"]);
}
