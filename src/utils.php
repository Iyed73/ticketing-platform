<?php

function hasOnGoingReservation($eventId, $userId) {
    $reservationModel = new EventReservationModel();

    return $reservationModel->getReservationId($eventId, $userId);
}