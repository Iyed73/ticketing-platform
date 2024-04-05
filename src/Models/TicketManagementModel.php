<?php

require_once "Repo.php";

class TicketManagementModel extends Repo
{
    public function __construct() {
        parent::__construct("ticket");
    }

    public function createTicket($buyerId, $eventId, $firstName, $lastName, $email): bool|string{
        $ticketId = $this->generateTicketId();
        $ticketData = array(
            "ticket_id" => $ticketId,
            "buyer_id" => $buyerId,
            "event_id" => $eventId,
            "first_name" => $firstName,
            "last_name" => $lastName,
            "email" => $email
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
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':ticket_id', $ticketId, PDO::PARAM_STR);
        $stmt->bindParam(':buyer_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        $count = $stmt->fetchColumn();
        return $count > 0;
    }
}


