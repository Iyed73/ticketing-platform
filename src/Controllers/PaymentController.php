<?php
require_once "../Models/EventReservationModel.php";
require_once "../Models/TicketManagementModel.php";

class PaymentController {

    private EventReservationModel $eventReservationModel;
    private TicketManagementModel $ticketModel;

    public function __construct() {
        $this->eventReservationModel= new EventReservationModel();
        $this->ticketModel = new TicketManagementModel();
    }

    public function handleGetRequest($userId, $reservationId) {
        if ($this->eventReservationModel->isReservationExpired($reservationId)) {
            $eventId = $this->eventReservationModel->getEventIdForReservation($reservationId);
            header("Location: /event?event_id=" . urlencode($eventId));
        }
        if ($this->eventReservationModel->isValidReservation($userId, $reservationId)) {
            $quantity = $this->eventReservationModel->getReservationQuantity($reservationId);
            header("Location: ../View/paymentView.php?reservation_id=$reservationId&quantity=$quantity");
            exit();
        } else {
            http_response_code(401);
            exit();
        }
    }

    public function handlePostRequest($userId) {
        $reservationId = $_POST["reservation_id"];
        if (!$this->eventReservationModel->isValidReservation($userId, $reservationId)) {
            http_response_code(401);
            exit;
        }
        $quantity = $this->eventReservationModel->getReservationQuantity($reservationId);

        $firstNames = $_POST["first_names"];
        $lastNames = $_POST["last_names"];
        $emails = $_POST["emails"];

        $creditCard = $_POST["credit_card"];

        if (count($firstNames) !== $quantity || count($lastNames) !== $quantity || count($emails) !== $quantity) {
            header("Location: ../View/paymentView.php?reservation_id=$reservationId&quantity=$quantity");
            exit();
        }
        $eventId = $this->eventReservationModel->getEventIdForReservation($reservationId);

        if ($this->eventReservationModel->isReservationExpiredWithDelete($reservationId)) {
            $this->eventReservationModel->increaseAvailableTickets($eventId, $quantity);
            return;
        }

        if ($this->processPayment($creditCard)) {
            echo "Payment processed successfully!";
             $buyerId = $userId;
            for ($i = 0; $i < $quantity; $i++) {
                $eventId = $reservationId;
                $firstName = $firstNames[$i];
                $lastName = $lastNames[$i];
                $email = $emails[$i];

                $ticketResult = $this->ticketModel->createTicket($buyerId, $eventId, $firstName, $lastName, $email);

                if ($ticketResult !== true) {
                    echo "Error creating ticket: $ticketResult";
                }
            }


        } else {
            echo "Error: Payment processing failed.";
        }
    }

    private function processPayment($creditCard): bool {
        // If payment is successful, return true;
        // always true in our case since we are not simulating a real payment system
        return true; // Placeholder for successful payment
    }

}

session_start();

if (!isset($_SESSION["user_id"])) {
    http_response_code(401);
    exit();
}

$userId = $_SESSION["user_id"];

$paymentController = new PaymentController();

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    $reservationId = $_GET["reservation_id"] ?? null;
    if ($reservationId === null) {
        http_response_code(400);
        exit();
    }
    $paymentController->handleGetRequest($userId, $reservationId);
} elseif ($_SERVER["REQUEST_METHOD"] === "POST") {
    $paymentController->handlePostRequest($userId);
}
