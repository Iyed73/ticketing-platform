<?php
require_once "src/Models/NotificationsRepo.php";
class notificationController {
    private $notificationsRepo;

    public function __construct() {
        $this->notificationsRepo = new NotificationsRepo();
    }
    public function displayNumberOfUnreadNotifications($userId) {
        $numberOfUnreadNotifications = $this->notificationsRepo->getNumberOfUnreadNotifcations($userId);
        if ($numberOfUnreadNotifications > 0) {
            echo "<div class='notifNumber'>$numberOfUnreadNotifications</div>";
        }
        else {
            echo "<div class='notifNumber' style='display: none;'></div>";
        }
    }
    public function displayAllNotifications($userId) {
        $prefix = $_ENV['prefix'];
        $notifications = $this->notificationsRepo->findNotificationsByUserId($userId);
        if($notifications == null) {
            echo "<div class='notifSec'>";
            echo "<a href='#'>";
            echo "<div class='notifTxt'>No Notifications</div>";
            echo "</a>";
            echo "</div>";
        }
        else {
            global $uri;
            foreach ($notifications as $notification) {
                $notificationId = $notification->id;
                $notificationSender  = $notification->sender;
                $notificationContent = $notification->content;
                $notificationDate = $notification->created_at;
                $notificationStatus = $notification->is_read;

                if ($notificationStatus == 'unread') {
                    echo "<div class='notifSec new'>";
                }
                else {
                    echo "<div class='notifSec'>";
                }
                echo "<a href='$prefix/notifications?function=read&id=$notificationId&RequestUrl=$uri'>";
                echo "<div class='notifTxt'>$notificationSender: $notificationContent</div>";
                echo "<div class='notifTxt sub'>$notificationDate</div>";
                echo "</a>";
                echo "</div>";
            }
        }
    }

    function markNotificationAsRead($notificationId) {
        $this->notificationsRepo->markNotificationAsRead($notificationId);
    }

    function deleteNotifications($userId) {
        $this->notificationsRepo->deleteNotifications($userId);
    }
}

if(isset($_GET['function'])) {
    $function = $_GET['function'];
    $userId = $_SESSION['user_id'];
    $notificationController = new notificationController();
    if ($function == 'deleteNotifications') {
        $notificationController->deleteNotifications($userId);
    }
    elseif ($function == 'read') {
        $notificationId = $_GET['id'];
        $notificationController->markNotificationAsRead($notificationId);
    }
    $prefix = $_ENV['prefix'];
    $uri = $_GET['RequestUrl'];
    header("Location: $uri");
    die();
}