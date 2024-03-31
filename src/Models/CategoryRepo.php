<?php 
require_once "Repo.php";
class CategoryRepo extends Repo {
    public function __construct() {
        parent::__construct('categories');
    }

    public function deleteByname($name) {
        $req = "DELETE FROM {$this->tableName} WHERE name = :name";
        $response = $this->db->prepare($req);
        $response->bindParam(':name', $name);
        return $response->execute();
    }
}