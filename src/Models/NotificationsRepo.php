<?php
require_once "src\Models\Repo.php";
class NotificationsRepo extends Repo {
    public function __construct() {
        parent::__construct('notifications');
    }

    public function findNotificationsByUserId($userId) {
        $req = "SELECT * FROM {$this->tableName} WHERE user_id = :userId Order by created_at DESC";
        $response = $this->db->prepare($req);
        $response->bindParam(':userId', $userId);
        $response->execute();
        return $response->fetchAll(PDO::FETCH_OBJ);
    }

    public function getNumberOfUnreadNotifcations($userId) {
        $req = "SELECT COUNT(*) as count FROM {$this->tableName} WHERE user_id = :userId AND is_read = 'unread'";
        $response = $this->db->prepare($req);
        $response->bindParam(':userId', $userId);
        $response->execute();
        return $response->fetch(PDO::FETCH_OBJ)->count;
    }

    public function markAllNotificationsAsRead($userId) {
        $req = "UPDATE {$this->tableName} SET is_read = 'read' WHERE user_id = :userId";
        $response = $this->db->prepare($req);
        $response->bindParam(':userId', $userId);
        return $response->execute();
    }
    
    public function markNotificationAsRead($notificationId) {
        $req = "UPDATE {$this->tableName} SET is_read = 'read' WHERE id = :notificationId";
        $response = $this->db->prepare($req);
        $response->bindParam(':notificationId', $notificationId);
        return $response->execute();
    }

    public function deleteNotifications($userId) {
        $req = "DELETE FROM {$this->tableName} WHERE user_id = :userId";
        $response = $this->db->prepare($req);
        $response->bindParam(':userId', $userId);
        return $response->execute();
    }

}