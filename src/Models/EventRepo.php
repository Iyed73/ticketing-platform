<?php 
require_once "Repo.php";
class EventRepo extends Repo {
    public function __construct() {
        parent::__construct('events');
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
    
    public function getEventList() {
        $req = "SELECT name FROM {$this->tableName}";
        $response = $this->db->prepare($req);
        $response->execute();
        return $response->fetchAll(PDO::FETCH_OBJ);
    }

    public function deleteByName($eventName) {
        $req = "DELETE FROM {$this->tableName} WHERE name = :name";
        $response = $this->db->prepare($req);
        $response->bindParam(':name', $eventName);
        return $response->execute();
    }
}