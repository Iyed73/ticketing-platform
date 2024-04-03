<?php 
require_once "src\Models\Repo.php";
class UserRepo extends Repo {
    public function __construct() {
        parent::__construct('users');
    }

    public function findByUsername($username) {
        $req = "SELECT * FROM {$this->tableName} where username = :username";
        $response = $this->db->prepare($req);
        $response->bindParam(':username', $username);
        $response->execute();
        return $response->fetch(PDO::FETCH_OBJ);
    }

    public function findByEmail($email) {
        $req = "SELECT * FROM {$this->tableName} where email = :email";
        $response = $this->db->prepare($req);
        $response->bindParam(':email', $email);
        $response->execute();
        return $response->fetch(PDO::FETCH_OBJ);
    }

    public function updatePassword($id, $password) {
        $req = "UPDATE {$this->tableName} SET pwd = :pwd WHERE id = :id";
        $response = $this->db->prepare($req);
        $response->bindParam(':pwd', $password);
        $response->bindParam(':id', $id);
        return $response->execute();
    }
    
    public function deleteByUsername($username) {
        $req = "DELETE FROM {$this->tableName} WHERE username = :username";
        $response = $this->db->prepare($req);
        $response->bindParam(':username', $username);
        return $response->execute();
    }
}