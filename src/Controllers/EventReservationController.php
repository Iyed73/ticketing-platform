<?php
require_once("src/Models/EventReservationModel.php");
require_once("src/Models/EventRepo.php");
require_once("src/Models/UserRepo.php");


class EventReservationController {
    private EventReservationModel $eventReservationModel;
    private EventRepo $eventModel;
    private UserRepo $userModel;


    public function __construct() {
        $this->eventReservationModel = new EventReservationModel();
        $this->eventModel = new EventRepo();
        $this->userModel = new UserRepo();
    }

    public function handleReservationRequest() {
        $eventId = $_POST["event_id"] ?? null;
        $quantity = $_POST["quantity"] ?? null;


        if ($eventId === null || $quantity === null) {
            http_response_code(400); // Bad Request
            exit();
        }

        $event = $this->eventModel->findById($eventId);
        if (!$event) {
            http_response_code(400); // Bad Request
            exit();
        }

        if (!isset($_SESSION["user_id"])) {
            $_SESSION["error"] = "You must login to make a purchase.";
            header("Location: event?id=" . urlencode($eventId));
            exit();
        }

        $userId = $_SESSION["user_id"];

        if (!$this->userModel->isUserVerified($userId)) {
            $_SESSION["error"] = "You must verify your account to make a purchase.";
            header("Location: event?id=" . urlencode($eventId));
            exit();
        }

        if (!$this->eventModel->isEventOnSellTime($eventId)) {
            $_SESSION["error"] = "Tickets are not on sale yet.";
            header("Location: event?id=" . urlencode($eventId));
            exit();
        }
        try {
            $reservationResult = $this->eventReservationModel->reserveTickets($eventId, $userId, $quantity);
        } catch (Exception $e) {
            error_log($e->getMessage());
            $_SESSION["error"] = "An error occurred.";
            header("Location: event?id=" . urlencode($eventId));
            exit();
        }
        if ($reservationResult === true) {
            $reservationId = $this->eventReservationModel->getReservationId($eventId, $userId);
            if ($reservationId !== null) {
                sleep(1);
                $_SESSION["reservation_id"] = $reservationId;
                header("Location: payment?reservation_id=" . urlencode($reservationId));
            } else {
                header("Location: event?id=" . urlencode($eventId));
            }
        } else {

            $_SESSION["error"] = $reservationResult;
            header("Location: event?id=" . urlencode($eventId));
        }
        exit();
    }
}


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $controller = new EventReservationController();
    $controller->handleReservationRequest();

} else {
    http_response_code(405); // Not Allowed status
    exit();
}

