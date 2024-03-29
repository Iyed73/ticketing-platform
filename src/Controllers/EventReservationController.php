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