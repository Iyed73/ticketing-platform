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

    private function isValidReservation($reservation, $userId): bool {
        return $reservation->user_id === $userId;
    }

    private function isReservationExpired($reservation): bool {
        $expirationDate = $reservation->expiration;
        return strtotime($expirationDate) < time();
    }

    private function generateTicketId(): string {
        return uniqid('INSAT', true);
    }

    public function handleGetRequest() {
        $reservationId = $_GET["reservation_id"] ?? null;
        if ($reservationId === null) {
            http_response_code(400);
            exit();
        }

        $reservation = $this->eventReservationModel->findById($reservationId);

        if (!$reservation) {
            http_response_code(404);
            exit();
        }

        $userId = $_SESSION["user_id"];
        $eventId = $reservation->event_id;

        if (!$this->isValidReservation($reservation, $userId)) {
            http_response_code(401);
            exit();
        }

        if ($this->isReservationExpired($reservation)) {
            $this->eventReservationModel->cancelReservation($reservationId);
            header("Location: event?id=" . urlencode($eventId));
            exit();
        }

        $quantity = $reservation->quantity;
        $totalPrice = $this->getTotalPrice($eventId, $quantity);
        $expiration = $reservation->expiration;

        require_once "src/Views/paymentView.php";

        exit();
    }
    public function handlePostRequest() {
        $userId = $_SESSION['user_id'];
        $reservationId = $_POST["reservation_id"];

        $reservation = $this->eventReservationModel->findById($reservationId);

        if ($reservation === null) {
            http_response_code(404);
            exit();
        }

        if (!$this->isValidReservation($reservation, $userId)) {
            http_response_code(401);
            exit;
        }
        $quantity = $reservation->quantity;

        $firstNames = $_POST["first_names"];
        $lastNames = $_POST["last_names"];
        $emails = $_POST["emails"];

        $creditCard = $_POST["credit_card"];

        if (count($firstNames) !== $quantity || count($lastNames) !== $quantity || count($emails) !== $quantity) {
            $_SESSION["error"] = "An error occurred, please try again";
            header("Location: payment?reservation_id=$reservationId&quantity=$quantity");
            exit();
        }
        $eventId = $reservation->event_id;

        if ($this->eventReservationModel->isReservationExpiredWithDelete($reservationId)) {
            $this->eventReservationModel->increaseAvailableTickets($eventId, $quantity);
            $_SESSION["error"] = "Failed to complete payment before expiration time";
            header("Location: event?id=$eventId");
        }

        $totalPrice = $this->getTotalPrice($eventId, $quantity);

        if ($this->processPayment($creditCard, $totalPrice)) {
            $buyerId = $userId;
            $price = $this->eventModel->getTicketPrice($eventId);
            $ticketDataArray = array();

            for ($i = 0; $i < $quantity; $i++) {
                $firstName = $firstNames[$i];
                $lastName = $lastNames[$i];
                $email = $emails[$i];

                $ticketDataArray[] = array(
                    "ticket_id" => $this->generateTicketId(),
                    "buyer_id" => $buyerId,
                    "event_id" => $eventId,
                    "first_name" => $firstName,
                    "last_name" => $lastName,
                    "email" => $email,
                    "price" => $price
                );
            }
            try {
                $this->ticketModel->createTickets($ticketDataArray);
                header("Location: view-tickets");
            } catch (Exception $e) {
                error_log($e->getMessage());
                $this->eventReservationModel->increaseAvailableTickets($eventId, $quantity);
                $_SESSION["error"] = "An error occurred.";
                header("Location: event?id=$eventId");
            }
        }
        exit();
    }

    private function processPayment($creditCard, $totalPrice): bool {
        // If payment is successful, return true;
        // always true in our case since we are not simulating a real payment system
        sleep(2); // todo: add loading spinner
        return true;
    }


    private function refundPayment($creditCard, $totalPrice): bool {
        // If tickets creation failed the payment is refunded
        sleep(2); // todo: add loading spinner
        return true;
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
