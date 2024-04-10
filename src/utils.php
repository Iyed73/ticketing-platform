<?php

function hasOnGoingReservation($eventId, $userId) {
    $reservationModel = new EventReservationModel();

    return $reservationModel->getReservationId($eventId, $userId);
}

function generateRandomImageName($extension): string {
    return uniqid('image_') . '.' . $extension;
}

