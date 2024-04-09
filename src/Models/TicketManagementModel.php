<?php

require_once "Repo.php";

class TicketManagementModel extends Repo
{
    public function __construct() {
        parent::__construct("ticket");
    }

    public function createTickets(array $ticketDataArray): bool {
        $values = array();
        $placeholders = array();

        foreach ($ticketDataArray as $ticketData) {
            $placeholders[] = '(' . rtrim(str_repeat('?,', count($ticketData)), ',') . ')';
            $values = array_merge($values, array_values($ticketData));
        }

        $query = "INSERT INTO `{$this->tableName}` (" . implode(', ', array_keys($ticketDataArray[0])) . ") VALUES " . implode(', ', $placeholders);
        $response = $this->db->prepare($query);

        return $response->execute($values);
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

    public function getAllTicketsTable() {
        $query = "SELECT * FROM {$this->tableName}";

        $response = $this->db->query($query);
        $tickets = $response->fetchAll(PDO::FETCH_ASSOC);
        return $tickets;
    }

    public function getTicketInfoById($ticketId) {
        $query = "SELECT {$this->tableName}.*, events.name AS event_name, events.venue, events.eventDate, 
              users.firstname AS buyer_firstname, users.lastname AS buyer_lastname
              FROM {$this->tableName}
              INNER JOIN events ON {$this->tableName}.event_id = events.id
              INNER JOIN users ON {$this->tableName}.buyer_id = users.id
              WHERE {$this->tableName}.ticket_id = :ticket_id";

        $response = $this->db->prepare($query);
        $response->bindParam(':ticket_id', $ticketId, PDO::PARAM_STR);
        $response->execute();
        $ticketInfo = $response->fetch(PDO::FETCH_OBJ);
        return $ticketInfo;
    }






    public function getNearEvents($userId) {
        $query = "SELECT E.name as name, E.venue as venue
            FROM events E
            INNER JOIN {$this->tableName} T ON E.id = T.event_id
            WHERE T.buyer_id = :buyer_id 
            AND E.eventDate BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 1 DAY)
            AND T.is_notification_sent = 0
            GROUP BY E.id";
        $response = $this->db->prepare($query);
        $response->bindParam(':buyer_id', $userId, PDO::PARAM_INT);
        $response->execute();
        return $response->fetchAll(PDO::FETCH_OBJ);
    }
    

    public function markTicketsAsNotified($userId) {
        $query = "UPDATE {$this->tableName} T
            INNER JOIN events E ON T.event_id = E.id
            SET T.is_notification_sent = 1
            WHERE T.buyer_id = :buyer_id
            AND E.eventDate BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 1 DAY)";
        $response = $this->db->prepare($query);
        $response->bindParam(':buyer_id', $userId, PDO::PARAM_INT);
        return $response->execute();
    }
}


