<?php

require_once "Repo.php";

class TicketManagementModel extends Repo
{
    public function __construct() {
        parent::__construct("ticket");
    }

    public function createTicket($buyerId, $eventId, $firstName, $lastName, $email, $price): bool|string {
        $ticketId = $this->generateTicketId();
        $ticketData = array(
            "ticket_id" => $ticketId,
            "buyer_id" => $buyerId,
            "event_id" => $eventId,
            "first_name" => $firstName,
            "last_name" => $lastName,
            "email" => $email,
            "price" => $price
        );
        $this->insert($ticketData);
        return true;
    }

    private function generateTicketId(): string {
        return uniqid();
    }

    public function getAllTickets($buyerId) {
        $query = "SELECT {$this->tableName}.*, events.name AS event_name, events.venue, events.eventDate
              FROM ticket
              INNER JOIN events ON ticket.event_id = events.id
              WHERE ticket.buyer_id = :buyer_id
              ORDER BY ticket.buy_date DESC";

        $response = $this->db->prepare($query);
        $response->bindParam(':buyer_id', $buyerId, PDO::PARAM_INT);
        $response->execute();
        return $response->fetchAll(PDO::FETCH_ASSOC);
    }

    public function isTicketValidForUser($ticketId, $userId): bool {
        $query = "SELECT COUNT(*) FROM {$this->tableName} WHERE ticket_id = :ticket_id AND buyer_id = :buyer_id";
        $response = $this->db->prepare($query);
        $response->bindParam(':ticket_id', $ticketId, PDO::PARAM_STR);
        $response->bindParam(':buyer_id', $userId, PDO::PARAM_INT);
        $response->execute();
        $count = $response->fetchColumn();
        return $count > 0;
    }

    public function getTicketInfo($ticketId, $buyerId) {
        $query = "SELECT ticket.*, events.name AS event_name, events.venue, events.eventDate, 
              users.firstname, users.lastname
              FROM {$this->tableName}
              INNER JOIN events ON ticket.event_id = events.id
              INNER JOIN users ON ticket.buyer_id = users.id
              WHERE ticket.ticket_id = :ticket_id AND ticket.buyer_id = :buyer_id";

        $response = $this->db->prepare($query);
        $response->bindParam(':ticket_id', $ticketId, PDO::PARAM_STR);
        $response->bindParam(':buyer_id', $buyerId, PDO::PARAM_INT);
        $response->execute();
        $ticketInfo = $response->fetch(PDO::FETCH_ASSOC);

        $ticketInfo['ticketId'] = $ticketInfo['ticket_id'];
        $ticketInfo['eventName'] = $ticketInfo['event_name'];
        $ticketInfo['eventVenue'] = $ticketInfo['venue'];
        $ticketInfo['purchaseDate'] = $ticketInfo['buy_date'];
        $ticketInfo['buyerName'] = $ticketInfo['firstname'] . ' ' . $ticketInfo['lastname'];
        $ticketInfo['ticketHolderName'] = $ticketInfo['first_name'] . ' ' . $ticketInfo['last_name'];
        $ticketInfo['price'] = $ticketInfo['price'] / 100;

        return $ticketInfo;
    }
}


