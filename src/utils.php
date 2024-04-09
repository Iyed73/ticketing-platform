<?php

require_once "src/Models/EventReservationModel.php";

function hasOnGoingReservation($eventId, $userId) {
    $reservationModel = new EventReservationModel();

    return $reservationModel->getReservationId($eventId, $userId);
}
