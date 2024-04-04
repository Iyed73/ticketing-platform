<?php
require_once("src/Models/UserRepo.php");
require_once("src/Models/EventRepo.php");

class DashboardController {
    private UserRepo $userRepo;
    private EventRepo $eventRepo;
    private $events;

    public function __construct() {
        $this->userRepo = new UserRepo();
        $this->eventRepo = new EventRepo();
    }

   /* public function eventsDashboard() {

    }*/

    public function adminDashboard() {
        require_once "src/Views/Dashboard/adminDashboard.php";
    }

    public function handleRequest($userID) {
        if ($this->userRepo->isAdmin($userID)) {
            $this->adminDashboard();
            $events = $this->eventRepo->findAll();
            require_once "src/Views/Dashboard/eventsDashboard.php";
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
?>
