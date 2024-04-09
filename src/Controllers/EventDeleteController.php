<?php

class EventDeleteController {
    private $EventModel;

    public function __construct() {
        $this->EventModel = new EventModel();
    }

    public function deleteEvent($eventId) {
        $this->EventModel->deleteById($eventId);
        header("Location: all_events?eventDeleted=true");
        exit();
    }

    public function handleGetRequest($userID, $eventID) {
        $UserModel = new UserModel();

        if ($UserModel->isAdmin($userID)) {
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
