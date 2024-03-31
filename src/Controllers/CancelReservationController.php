<?php
require_once "../Models/EventReservationModel.php";

class CancelReservationController {
    private EventReservationModel $eventReservationModel;

    public function __construct() {
        $this->eventReservationModel = new EventReservationModel();
    }

    public function handlePostRequest($userId, $reservationId) {
        if (!$this->eventReservationModel->isValidReservation($userId, $reservationId)) {
            http_response_code(401);
        }

        $this->eventReservationModel->cancelReservation($reservationId);

        header("Location: /home");
    }
}


session_start();

if (!isset($_SESSION["user_id"])) {
    http_response_code(401);
    exit();
}

$userId = $_SESSION["user_id"];

$cancelController = new CancelReservationController();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $reservationId = $_POST["reservation_id"] ?? null;
    if ($reservationId === null) {
        http_response_code(400);
    }
    $cancelController->handlePostRequest($userId, $reservationId);
}
