<?php

require_once "src/Models/EventRepo.php";
require_once "src/Models/UserRepo.php";

class EventDeleteController {
    private $eventRepo;

    public function __construct() {
        $this->eventRepo = new EventRepo();
    }

    public function deleteEvent($eventId) {
        $this->eventRepo->delete($eventId);
        header("Location: all_events?eventDeleted=true");
        exit();
    }

    public function handleGetRequest($userID, $eventID) {
        $userRepo = new UserRepo();

        if ($userRepo->isAdmin($userID)) {
            $this->deleteEvent($eventID);
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
}

$userID = $_SESSION["user_id"];

$eventDeleteController = new EventDeleteController();

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    if (!isset($_GET['id'])) {
        header("Location: home");
        exit();
    }
    $eventID = $_GET['id'];
    $eventDeleteController->handleGetRequest($userID, $eventID);
} else {
    http_response_code(405);
    exit();
}
