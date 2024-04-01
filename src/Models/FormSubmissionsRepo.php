<?php
require_once "Repo.php";
class FormSubmissionsRepo extends Repo
{
    public function __construct()
    {
        parent::__construct('form_submissions');
    }

    // Insert form submission
    public function insertFormSubmission($name,$email, $subject, $message, $date)
    {
        $sql = "INSERT INTO {$this->tableName} (name,email, subject, message, date) VALUES (:name,:email, :subject, :message, :date)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':subject', $subject);
        $stmt->bindParam(':message', $message);
        $stmt->bindParam(':date', $date);
        $stmt->execute();
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


