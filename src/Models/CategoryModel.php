<?php 

class CategoryModel extends AbstractModel {
    public function __construct() {
        parent::__construct('categories');
    }

    public function deleteByname($name) {
        $req = "DELETE FROM {$this->tableName} WHERE name = :name";
        $response = $this->db->prepare($req);
        $response->bindParam(':name', $name);
        return $response->execute();
    }

    public function categoryExists($categoryName) {
        $req = "SELECT COUNT(*) FROM categories WHERE name = :name";
        $stmt = $this->db->prepare($req);
        $stmt->bindParam(':name', $categoryName);
        $stmt->execute();
        $count = $stmt->fetchColumn();
        if ($count > 0) {
            return true;
        } else {
            return false;
        }
    }

}