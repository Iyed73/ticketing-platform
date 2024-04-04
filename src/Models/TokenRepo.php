<?php 
require_once "src\Models\Repo.php";
class TokenRepo extends Repo {
    public function __construct() {
        parent::__construct('tokens');
    }

    public function findByToken($token) {
        $req = "SELECT * FROM {$this->tableName} where token = :token";
        $response = $this->db->prepare($req);
        $response->bindParam(':token', $token);
        $response->execute();
        return $response->fetch(PDO::FETCH_OBJ);
    }

    public function deleteByToken($token) {
        $req = "DELETE FROM {$this->tableName} WHERE token = :token";
        $response = $this->db->prepare($req);
        $response->bindParam(':token', $token);
        return $response->execute();
    }

    public function findByUserIdAndType($userId, $type) {
        $req = "SELECT * FROM {$this->tableName} where user_id = :user_id AND type = :type";
        $response = $this->db->prepare($req);
        $response->bindParam(':user_id', $userId);
        $response->bindParam(':type', $type);
        $response->execute();
        return $response->fetch(PDO::FETCH_OBJ);
    }

    
}