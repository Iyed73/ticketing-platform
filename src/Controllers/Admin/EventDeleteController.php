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
        $userModel = new UserModel();

        if ($userModel->isAdmin($userID)) {
            $imagePath = $this->EventModel->getImagePath($eventID);
            if ($imagePath) {
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }
            $this->EventModel->deleteById($eventID);
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit();
        } else {
            http_response_code(401);
            exit();
        }
    }
}


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
