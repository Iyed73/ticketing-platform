<?php 
require_once "src\Models\Repo.php";
class UserRepo extends Repo {
    public function __construct() {
        parent::__construct('users');
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

    public function updateFirstName($id,$firstname){
        $req = "UPDATE {$this->tableName} SET firstname = :firstname WHERE id = :id";
        $response = $this->db->prepare($req);
        $response->bindParam(':firstname', $firstname);
        $response->bindParam(':id', $id);
        return $response->execute();
    }

    public function updateLastName($id,$lastname){
        $req = "UPDATE {$this->tableName} SET lastname = :lastname WHERE id = :id";
        $response = $this->db->prepare($req);
        $response->bindParam(':lastname', $lastname);
        $response->bindParam(':id', $id);
        return $response->execute();
    }

    public function verifyUser($id) {
        $req = "UPDATE {$this->tableName} SET is_verified = 1 WHERE id = :id";
        $response = $this->db->prepare($req);
        $response->bindParam(':id', $id);
        return $response->execute();
    }

    public function updateLastTokenSent($id) {
        $req = "UPDATE {$this->tableName} SET last_recovery_token_sent_at = NOW() WHERE id = :id";
        $response = $this->db->prepare($req);
        $response->bindParam(':id', $id);
        return $response->execute();
    }

    public function getOldPasswordHash($id) {
        $req = "SELECT pwd FROM {$this->tableName} WHERE id = :id";
        $response = $this->db->prepare($req);
        $response->bindParam(':id', $id);
        $response->execute();
        return $response->fetch(PDO::FETCH_OBJ);
    }
    
    public function deleteByUsername($username) {
        $req = "DELETE FROM {$this->tableName} WHERE username = :username";
        $response = $this->db->prepare($req);
        $response->bindParam(':username', $username);
        return $response->execute();
    }


    public function isUserVerified($id) {
        $query = "SELECT is_verified FROM {$this->tableName} WHERE id = :id";
        $response = $this->db->prepare($query);

    public function isAdmin($id){
        $req = "SELECT role FROM {$this -> tableName} WHERE id =:id";
        $response = $this->db->prepare($req);

        $response->bindParam(':id', $id);
        $response->execute();
        $result = $response->fetch(PDO::FETCH_ASSOC);

        return $result['is_verified'] === 1;

        if($result && $result['role'] === 'admin'){
            return true;
        }
        else{
            return false;
        }

    }
}