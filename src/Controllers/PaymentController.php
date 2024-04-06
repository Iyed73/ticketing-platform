<?php
require_once "src/Models/EventReservationModel.php";
require_once "src/Models/TicketManagementModel.php";
require_once "src/Models/EventRepo.php";

class PaymentController {

    private EventReservationModel $eventReservationModel;
    private TicketManagementModel $ticketModel;
    private EventRepo $eventModel;

    public function __construct() {
        $this->eventReservationModel= new EventReservationModel();
        $this->ticketModel = new TicketManagementModel();
        $this->eventModel = new EventRepo();
    }

    private function getTotalPrice($eventId, $quantity) {
        $price = $this->eventModel->getTicketPrice($eventId);
        $totalPrice = $price * $quantity / 100;
        return $totalPrice;
    }

    public function handleGetRequest() {
        $reservationId = $_GET["reservation_id"] ?? null;
        if ($reservationId === null) {
            http_response_code(400);
            exit();
        }

        $userId = $_SESSION["user_id"];
        $eventId = $this->eventReservationModel->getEventIdForReservation($reservationId);

        if ($this->eventReservationModel->isReservationExpired($reservationId)) {
            $this->eventReservationModel->cancelReservation($reservationId);
            header("Location: event?id=" . urlencode($eventId));
        }
        else if ($this->eventReservationModel->isValidReservation($userId, $reservationId)) {
            $quantity = $this->eventReservationModel->getReservationQuantity($reservationId);
            $totalPrice = $this->getTotalPrice($eventId, $quantity);

            $expiration = $this->eventReservationModel->getReservationExpiration($reservationId);

            require_once "src/Views/paymentView.php";
        } else {
            http_response_code(401);
        }
        exit();
    }
    public function handlePostRequest() {
        $userId = $_SESSION['user_id'];
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
        $totalPrice = $this->getTotalPrice($eventId, $quantity);

        if ($this->processPayment($creditCard, $totalPrice)) {
            $buyerId = $userId;
            $price = $this->eventModel->getTicketPrice($eventId);
            for ($i = 0; $i < $quantity; $i++) {
                $firstName = $firstNames[$i];
                $lastName = $lastNames[$i];
                $email = $emails[$i];
                try {
                    $ticketResult = $this->ticketModel->createTicket($buyerId, $eventId, $firstName, $lastName, $email, $price);
                }
                catch (Exception $e) {
                    // todo: handle ticket creation error
                }
            }
            header("Location: view-tickets");


        } else {
            $_SESSION["error"] = "Couldn't process payment";
            header("Location: event?id=$eventId");
        }
    }

    private function processPayment($creditCard, $totalPrice): bool {
        // If payment is successful, return true;
        // always true in our case since we are not simulating a real payment system
        sleep(2); // todo: add loading spinner
        return true; // Placeholder for successful payment
    }

}


if (!isset($_SESSION["user_id"])) {
    http_response_code(401);
    exit();
}


$paymentController = new PaymentController();

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    $paymentController->handleGetRequest();
} elseif ($_SERVER["REQUEST_METHOD"] === "POST") {
    $paymentController->handlePostRequest();
}
