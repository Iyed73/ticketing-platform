<?php
require_once "src\Models\Repo.php";
class FormSubmissionsRepo extends Repo
{
    public function __construct()
    {
        parent::__construct('form_submissions');
    }

    public function totalPagesNum($x){
        $req = "SELECT COUNT(*) FROM {$this -> tableName}";
        $response = $this -> db -> prepare($req);
        $response -> execute();
        $count = $response -> fetchColumn();
        $totalPages = ceil($count / $x);
        return $totalPages;
    }


    public function findWithOffset($offset, $totalPages){
        $req = "SELECT * FROM {$this -> tableName} LIMIT $offset, $totalPages ";
        $response = $this->db->query($req);
        $response->execute();
        return  $response->fetchAll(PDO::FETCH_OBJ);
    }

    // Delete a form submission by id
    public function deleteFormSubmissions($id)
    {
        $sql = "DELETE FROM {$this->tableName} WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }
}


