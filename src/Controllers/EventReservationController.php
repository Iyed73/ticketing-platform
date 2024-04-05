<?php
require_once("src/Models/EventReservationModel.php");
require_once("src/Models/EventRepo.php");


class EventReservationController {
    private EventReservationModel $eventReservationModel;
    private EventRepo $eventModel;


    public function __construct() {
        $this->eventReservationModel = new EventReservationModel();
        $this->eventModel = new EventRepo();
    }

    public function handleReservationRequest($eventId, $userId, $quantity) {
        if (!$this->eventModel->isEventOnSellTime($eventId)) {
            $_SESSION["error"] = "Tickets are not on sale yet.";
            header("Location: event?id=" . urlencode($eventId));
            exit();
        }

        $reservationResult = $this->eventReservationModel->reserveTickets($eventId, $userId, $quantity);
        if ($reservationResult === true) {
            $reservationId = $this->eventReservationModel->getReservationId($eventId, $userId);
            if ($reservationId !== null) {
                sleep(1);
                $_SESSION["reservation_id"] = $reservationId;
                header("Location: payment?reservation_id=" . urlencode($reservationId));
            } else {
                http_response_code(402);
                exit();

                header("Location: event?id=" . urlencode($eventId));
            }
        } else {

            $_SESSION["error"] = $reservationResult;
            header("Location: event?id=" . urlencode($eventId));
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

