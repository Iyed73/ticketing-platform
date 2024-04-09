<?php 
class UniqueTokenModel extends AbstractModel {
    public function __construct() {
        parent::__construct('unique_tokens');
    }

    public function findTokenBySelector($selector) {
        $req = "SELECT * FROM {$this->tableName} where selector = :selector and expiry > NOW()";
        $response = $this->db->prepare($req);
        $response->bindParam(':selector', $selector);
        $response->execute();
        return $response->fetch(PDO::FETCH_OBJ);
    }

    public function findUserBySelector($selector) {
        $req = "SELECT users.id, users.email, users.role
        FROM users
        INNER JOIN {$this->tableName} ON {$this->tableName}.user_id = users.id
        WHERE selector = :selector AND
        expiry > now()";
        $response = $this->db->prepare($req);
        $response->bindParam(':selector', $selector);
        $response->execute();
        return $response->fetch(PDO::FETCH_OBJ);
    }

    public function deleteByUserId($userId) {
        $req = "DELETE FROM {$this->tableName} WHERE user_id = :userId";
        $response = $this->db->prepare($req);
        $response->bindParam(':userId', $userId);
        return $response->execute();
    }
}