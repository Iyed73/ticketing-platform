<?php
require_once "src/Models/NotificationsRepo.php";
class notificationView {
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
        $notifications = $this->notificationsRepo->findNotificationsByUserId($userId);
        if($notifications == null) {
            echo "<div class='notifSec'>";
            echo "<a href='#'>";
            echo "<div class='notifTxt'>No Notifications</div>";
            echo "</a>";
            echo "</div>";
        }
        else {
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
                echo "<a href='#'>";
                echo "<div class='notifTxt'>$notificationSender: $notificationContent</div>";
                echo "<div class='notifTxt sub'>$notificationDate</div>";
                echo "</a>";
                echo "</div>";
            }
        }
    }
}