<?php
require_once "src/Models/EventReservationModel.php";


class CancelReservationController {
    private EventReservationModel $eventReservationModel;

    public function __construct() {
        $this->eventReservationModel = new EventReservationModel();
    }

    public function handlePostRequest() {
        $userId = $_SESSION["user_id"];
        $reservationId = $_POST["reservation_id"] ?? null;
        if ($reservationId === null) {
            http_response_code(400);
        }
        if (!$this->eventReservationModel->isValidReservation($userId, $reservationId)) {
            http_response_code(401);
        }

        $this->eventReservationModel->cancelReservation($reservationId);
        header("Location: home");
    }
}



if (!isset($_SESSION["user_id"])) {
    http_response_code(401);
    exit();
}



$cancelController = new CancelReservationController();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $cancelController->handlePostRequest();
}
