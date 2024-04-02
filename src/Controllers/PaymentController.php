<?php
require_once "src/Models/EventReservationModel.php";
require_once "src/Models/TicketManagementModel.php";

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
            $this->eventReservationModel->cancelReservation($reservationId);
            header("Location: event?id=" . urlencode($eventId));
        }
        else if ($this->eventReservationModel->isValidReservation($userId, $reservationId)) {
            $quantity = $this->eventReservationModel->getReservationQuantity($reservationId);
            require_once "src/Views/paymentView.php";
        } else {
            http_response_code(401);
        }
        exit();
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
            $_SESSION["error"] = "An error occurred, please try again";
            header("Location: payment?reservation_id=$reservationId&quantity=$quantity");
            exit();
        }
        $eventId = $this->eventReservationModel->getEventIdForReservation($reservationId);

        if ($this->eventReservationModel->isReservationExpiredWithDelete($reservationId)) {
            $this->eventReservationModel->increaseAvailableTickets($eventId, $quantity);
            $_SESSION["error"] = "Failed to complete payment before expiration time";
            header("Location: event?id=$eventId");
        }

        if ($this->processPayment($creditCard)) {
            $buyerId = $userId;
            for ($i = 0; $i < $quantity; $i++) {
                $firstName = $firstNames[$i];
                $lastName = $lastNames[$i];
                $email = $emails[$i];

                $ticketResult = $this->ticketModel->createTicket($buyerId, $eventId, $firstName, $lastName, $email);

//                if ($ticketResult !== true) {
//                    echo "Error creating ticket: $ticketResult";
//                }
            }
            header("Location: view-tickets");


        } else {
            $_SESSION["error"] = "Couldn't process payment";
            header("Location: event?id=$eventId");
        }
    }

    private function processPayment($creditCard): bool {
        // If payment is successful, return true;
        // always true in our case since we are not simulating a real payment system
        sleep(2); // todo: add loading spinner
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
