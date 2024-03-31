<?php
require_once("../Models/EventReservationModel.php");

class EventReservationController {
    private EventReservationModel $model;

    public function __construct() {
        $this->model = new EventReservationModel();
    }

    public function handleReservationRequest($eventId, $userId, $quantity) {
        $reservationResult = $this->model->reserveTickets($eventId, $userId, $quantity);
        if ($reservationResult === true) {
            $reservationId = $this->model->getReservationIdForUser($userId);
            if ($reservationId !== null) {
                session_start();
                $_SESSION["reservation_id"] = $reservationId;

                header("Location: /payment?reservation_id=" . urlencode($reservationId));
            } else {
                header("Location: /event?event_id=" . urlencode($eventId));
            }
        } else {
            header("Location: /event?event_id=" . urlencode($eventId));
        }
        exit();
    }
}


session_start();
if (!isset($_SESSION["user_id"])) {
    http_response_code(401); // Unauthorized
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $eventId = $_POST["event_id"] ?? null;
    $quantity = $_POST["quantity"] ?? null;

    if ($eventId !== null && $quantity !== null) {
        $controller = new EventReservationController();
        $userId = $_SESSION["user_id"];
        $controller->handleReservationRequest($eventId, $userId, $quantity);
    } else {
        http_response_code(400); // Bad Request
        exit();
    }
} else {
    http_response_code(405); // Not Allowed status
    exit();
}

