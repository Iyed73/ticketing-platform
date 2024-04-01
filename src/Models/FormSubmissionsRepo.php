<?php
require_once "Repo.php";
class FormSubmissionsRepo extends Repo
{
    public function __construct()
    {
        parent::__construct('form_submissions');
    }

    public function insertFormSubmission($email, $subject, $message, $status, $date)
    {
        $sql = "INSERT INTO {$this->tableName} (email, subject, message, status, date) VALUES (:email, :subject, :message, :status, :date)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':subject', $subject);
        $stmt->bindParam(':message', $message);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':date', $date);
        $stmt->execute();
    }
    // Retrieve all form submissions
    public function getAllFormSubmissions()
    {
        $sql = "SELECT * FROM {$this->tableName}";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function markAsResolved($id)
    {
        $status = "resolved";
        $sql = "UPDATE {$this->tableName} SET status = :status WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }
    function fetchLatestRows()
    {
        $sql = "SELECT * FROM {$this->tableName} ORDER BY id DESC LIMIT 5";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}


