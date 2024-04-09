<?php 
class EventModel extends AbstractModel {
    public function __construct() {
        parent::__construct('events');
    }

    public function findById($eventID) {
        $req = "SELECT * FROM {$this->tableName} where id = :eventID";
        $response = $this->db->prepare($req);
        $response->bindParam(':eventID', $eventID);
        $response->execute();
        return $response->fetch(PDO::FETCH_OBJ);
    }

    public function findByName($eventName) {
        $req = "SELECT * FROM {$this->tableName} where name = :name";
        $response = $this->db->prepare($req);
        $response->bindParam(':name', $eventName);
        $response->execute();
        return $response->fetch(PDO::FETCH_OBJ);
    }

    public function getSimilarEvents($eventCategory, $currentEventId, $amount = 1,) {
        $req = "SELECT * FROM {$this->tableName} where category = :category AND id != :id ORDER BY RAND() LIMIT {$amount}";
        $response = $this->db->prepare($req);
        $response->bindParam(':category', $eventCategory);
        $response->bindParam(':id', $currentEventId);
        $response->execute();
        return $response->fetchAll(PDO::FETCH_OBJ);
    }
    
    
    public function getResults($searchDescription) {
        $req = "SELECT * FROM {$this->tableName} 
        WHERE MATCH (shortDescription, longDescription, name, venue, organizer)
        AGAINST (:searchTerm IN NATURAL LANGUAGE MODE);";
        $response = $this->db->prepare($req);
        $response->bindParam(':searchTerm', $searchDescription);
        $response->execute();
        return $response->fetchAll(PDO::FETCH_OBJ);
    }

    public function deleteByName($eventName) {
        $req = "DELETE FROM {$this->tableName} WHERE name = :name";
        $response = $this->db->prepare($req);
        $response->bindParam(':name', $eventName);
        return $response->execute();
    }


    public function isEventOnSellTime($eventId) {
        $req = "SELECT startSellTime, eventDate FROM {$this->tableName} WHERE id = ?";
        $response = $this->db->prepare($req);
        $response->execute([$eventId]);
        $event = $response->fetch(PDO::FETCH_OBJ);

        if (!$event) {
            return false;
        }

        $currentDateTime = date('Y-m-d H:i:s');
        $startSellTime = $event->startSellTime;
        $eventDate = $event->eventDate;

        if ($currentDateTime >= $startSellTime && $currentDateTime <= $eventDate) {
            return true;
        } else {
            return false;
        }
    }

    public function getTicketPrice($eventId) {
        $req = "SELECT ticketPrice FROM {$this->tableName} WHERE id = ?";
        $response = $this->db->prepare($req);
        $response->execute([$eventId]);
        $ticketPrice = $response->fetchColumn();
        return $ticketPrice;
    }

    public function getImagePath($eventId) {
        $query = "SELECT imagePath FROM {$this->tableName} WHERE id = ?";
        $response = $this->db->prepare($query);
        $response->execute([$eventId]);
        $imagePath = $response->fetchColumn();
        return $imagePath;
    }

}