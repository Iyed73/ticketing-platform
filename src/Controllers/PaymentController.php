<?php
require_once "src/Models/EventReservationModel.php";
require_once "src/Models/TicketManagementModel.php";
require_once "src/Models/EventRepo.php";
require_once "src/Models/UserRepo.php";
require_once "Services/ticketGenerator.php";
require_once "Services/MailingService.php";



class PaymentController {

    private EventReservationModel $eventReservationModel;
    private TicketManagementModel $ticketModel;
    private EventRepo $eventModel;
    private UserRepo $userModel;

    public function __construct() {
        $this->eventReservationModel= new EventReservationModel();
        $this->ticketModel = new TicketManagementModel();
        $this->eventModel = new EventRepo();
        $this->userModel = new UserRepo();
    }

    private function getTotalPrice($price, $quantity) {
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

    private function parseTicketData($ticketDataArray, $event, $buyer): array {
        $parsedTickets = array();

        foreach ($ticketDataArray as $ticketData) {
            $parsedTickets[] = array(
                "ticketId" => $ticketData['ticket_id'],
                "eventName" => $event->name,
                "eventDate" => $event->eventDate,
                "eventVenue" => $event->venue,
                "purchaseDate" => $ticketData['buy_date'],
                "buyerName" => $buyer->firstname . ' ' . $buyer->lastname,
                "ticketHolderName" => $ticketData['first_name'] . ' ' . $ticketData['last_name'],
                "price" => $ticketData['price'] / 100,
            );
        }

        return $parsedTickets;
    }

    private function createRandomCombinatedTicketsName() {
        return uniqid('ticket');

    }

    private function sendTickets($ticketData, $receiverEmail) {

        $senderName = "Tickets Business";
        $receiverName = $ticketData[0]['buyerName'];


        $ticketCount = count($ticketData);
        if ($ticketCount > 1) {
            $subject = "Tickets for event: " . $ticketData[0]['eventName'];
            $messageHtml = "Dear $receiverName, <br><br> Attached are your tickets for the event: <strong>{$ticketData[0]['eventName']}</strong>.";
            $messageText = "Dear $receiverName, \n\n Attached are your tickets for the event: {$ticketData[0]['eventName']}.";
        } else {
            $subject = "Ticket for event: " . $ticketData[0]['eventName'];
            $messageHtml = "Dear $receiverName, <br><br> Attached is your ticket for the event: <strong>{$ticketData[0]['eventName']}</strong>.";
            $messageText = "Dear $receiverName, \n\n Attached is your ticket for the event: {$ticketData[0]['eventName']}.";
        }
        $fileName = $this->createRandomCombinatedTicketsName();
        generateCombinedTickets($ticketData, $fileName);

        $attachmentPath = __DIR__ . '\..\..\Static\attachments\\' . $fileName . '.pdf';


        $attachmentPaths = array($attachmentPath);
        sendMail($senderName, $receiverName, $receiverEmail, $subject, $messageHtml, $messageText, $attachmentPaths);

        if (file_exists($attachmentPath)) {
            unlink($attachmentPath);
        }
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

        $price = $this->eventModel->getTicketPrice($eventId);

        $totalPrice = $this->getTotalPrice($price, $quantity);
        $expiration = $reservation->expiration;

        require_once "src/Views/paymentView.php";

        exit();
    }

    public function handlePostRequest() {
        $userId = $_SESSION['user_id'];
        $reservationId = $_POST["reservation_id"];

        $reservation = $this->eventReservationModel->findById($reservationId);

        if (!$reservation) {
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
        $phoneNumbers = $_POST["phone_numbers"];

        $creditCard = $_POST["credit_card"];

        if (count($firstNames) !== $quantity || count($lastNames) !== $quantity || count($phoneNumbers) !== $quantity) {
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

        $event = $this->eventModel->findById($eventId);

        $user = $this->userModel->findById($userId);

        $price = $event->ticketPrice;

        $totalPrice = $this->getTotalPrice($price, $quantity);

        if ($this->processPayment($creditCard, $totalPrice)) {
            $buyerId = $userId;
            $ticketDataArray = array();
            $buyDate = date('Y-m-d H:i:s');
            for ($i = 0; $i < $quantity; $i++) {
                $firstName = $firstNames[$i];
                $lastName = $lastNames[$i];
                $phoneNumber = $phoneNumbers[$i];

                $ticketDataArray[] = array(
                    "ticket_id" => $this->generateTicketId(),
                    "buyer_id" => $buyerId,
                    "event_id" => $eventId,
                    "first_name" => $firstName,
                    "last_name" => $lastName,
                    "phone_number" => $phoneNumber,
                    "price" => $price,
                    "buy_date" => $buyDate,
                );
            }
            try {
                $this->ticketModel->createTickets($ticketDataArray);
            } catch (Exception $e) {
                error_log($e->getMessage());
                $this->eventReservationModel->increaseAvailableTickets($eventId, $quantity);
                $_SESSION["error"] = "An error occurred.";
                header("Location: event?id=$eventId");
                exit();
            }

            try {
                $ticketInfos = $this->parseTicketData($ticketDataArray, $event, $user);
                $this->sendTickets($ticketInfos, $user->email);
            } catch (Exception $e) {
                error_log("An error occurred while sending tickets via email: " . $e->getMessage());
            }
            header("Location: view-tickets");
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
