<?php 
require_once "Repo.php";
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

    public function deleteByUsername($username) {
        $req = "DELETE FROM {$this->tableName} WHERE username = :username";
        $response = $this->db->prepare($req);
        $response->bindParam(':username', $username);
        return $response->execute();
    }

    public function isAdmin($id){
        $req = "SELECT role FROM {$this -> tableName} WHERE id =:id";
        $response = $this->db->prepare($req);
        $response->bindParam(':id', $id);
        $response->execute();
        $result = $response->fetch(PDO::FETCH_ASSOC);

        if($result && $result['role'] === 'admin'){
            return true;
        }
        else{
            return false;
        }


    }
}