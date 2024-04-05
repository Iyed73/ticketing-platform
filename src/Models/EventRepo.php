<?php 
require_once "src\Models\Repo.php";
class EventRepo extends Repo {
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

    public function getEventsByCategory($eventCategory, $amount = 1) {
        $req = "SELECT * FROM {$this->tableName} where category = :category ORDER BY RAND() LIMIT {$amount}";
        $response = $this->db->prepare($req);
        $response->bindParam(':category', $eventCategory);
        $response->execute();
        return $response->fetchAll(PDO::FETCH_OBJ);
    }
    
    
    public function deleteByName($eventName) {
        $req = "DELETE FROM {$this->tableName} WHERE name = :name";
        $response = $this->db->prepare($req);
        $response->bindParam(':name', $eventName);
        return $response->execute();
    }

    public function totalPagesNum(){
        $req = "SELECT COUNT(*) FROM {$this -> tableName}";
        $response = $this -> db -> prepare($req);
        $response -> execute();
        $count = $response -> fetchColumn();
        $totalPages = ceil($count / 5);
        return $totalPages;
    }

    public function findWithOffset($offset, $totalPages){
        $req = "SELECT * FROM {$this -> tableName} LIMIT $offset, $totalPages ";
        $response = $this->db->query($req);
        $response->execute();
        return  $response->fetchAll(PDO::FETCH_OBJ);
    }

    public function updateEvent($Id, $name, $venue, $category, $eventDate, $shortDescription, $longDescription, $organizer, $startSellTime, $endSellTime, $totalTickets, $availableTickets, $ticketPrice) {
        $request = "UPDATE `{$this->tableName}` SET 
                name = '{$name}', 
                venue = '{$venue}', 
                category = '{$category}', 
                eventDate = '{$eventDate}', 
                shortDescription = '{$shortDescription}', 
                longDescription = '{$longDescription}', 
                organizer = '{$organizer}', 
                startSellTime = '{$startSellTime}', 
                endSellTime = '{$endSellTime}', 
                totalTickets = '{$totalTickets}', 
                availableTickets = '{$availableTickets}', 
                ticketPrice = '{$ticketPrice}' 
                WHERE id = '{$Id}'";
        $response = $this->db->prepare($request);

        return $response->execute();
    }


}