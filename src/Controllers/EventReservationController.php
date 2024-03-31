<?php
require_once("../Models/EventReservationModel.php");

class EventReservationController {
    private EventReservationModel $model;

    public function __construct() {
        $this->model = new EventReservationModel();
    }

    // todo: locations must be updated
    public function handleReservationRequest($eventId, $userId, $quantity) {
        $reservationResult = $this->model->reserveTickets($eventId, $userId, $quantity);
        $reservationId = $this->model->getReservationIdForUser($userId);
        if ($reservationResult === true) {
            $reservationId = $this->model->getReservationIdForUser($userId);
            if ($reservationId !== null) {
                session_start();
                $_SESSION["reservation_id"] = $reservationId;

                header("Location: payment_page.php");
            } else {
                header("Location: event_page.php?error=". urlencode("Reservation doesn't exist."));
            }
        } else {
            header("Location: event_page.php?error=". urlencode($reservationResult));
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

