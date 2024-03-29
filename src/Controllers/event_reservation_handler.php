<?php
require_once "EventReservationController.php";


session_start();
if (!isset($_SESSION["user_id"])) {
    http_response_code(401); // Unauthorized
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $eventId = $_POST["event_id"] ?? null;
    $quantity = $_POST["quantity"] ?? null;

    if ($eventId !== null  && $quantity !== null) {
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