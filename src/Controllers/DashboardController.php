<?php
require_once("src/Models/UserRepo.php");
require_once("src/Models/EventRepo.php");

class DashboardController {
    private UserRepo $userRepo;
    private EventRepo $eventRepo;
    private $allEvents;
    private $totalPages;
    private $currentPage;
    private $offset;

    public function __construct() {
        $this->userRepo = new UserRepo();
        $this->eventRepo = new EventRepo();
        $this->totalPages = $this->eventRepo->totalPagesNum();
        $this->currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
        $this->offset = ($this->currentPage - 1) * 5;
        $this->allEvents = $this->eventRepo->findWithOffset($this->offset, 5); // Assuming 5 events per page
    }

    public function adminDashboard() {
        if ($this->allEvents === null) {
            $this->allEvents = [];
        }
        $currentPage = $this->currentPage;
        $offset = $this->offset;
        $allEvents = $this->allEvents;
        $totalPages = $this->totalPages;
        require_once "src/Views/Dashboard/adminDashboard.php";
    }

    public function handleRequest($userID) {
        if ($this->userRepo->isAdmin($userID)) {
            $this->adminDashboard();
        } else {
            http_response_code(401);
            exit();
        }
    }
}

require_once "src/Controllers/includes/configSession.inc.php";

if (!isset($_SESSION["user_id"])) {
    http_response_code(401);
    exit();
} else {
    $dashboardController = new DashboardController();
    $dashboardController->handleRequest($_SESSION["user_id"]);
}
