<?php
require_once "src\Models\Repo.php";
class FormSubmissionsRepo extends Repo
{
    public function __construct()
    {
        parent::__construct('form_submissions');
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


