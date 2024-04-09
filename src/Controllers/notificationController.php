<?php
require_once "src/Models/NotificationsRepo.php";
require_once "src/Models/TicketManagementModel.php";

class notificationController {
    private $notificationsRepo;
    private $ticketManagementModel;

    public function __construct() {
        $this->notificationsRepo = new NotificationsRepo();
        $this->ticketManagementModel = new TicketManagementModel();
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
                echo "<a href='$prefix/notifications?function=read&id=$notificationId'>";
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

    public function addNearEventNotification($userId){
        //add notification for events that are happening in th next 24 hours
        $result = $this->ticketManagementModel->getNearEvents($userId);
        if($result !== null) {
            foreach ($result as $event) {
                $notificationContent = $event->name . " is happening soon at ".$event->venue." don't miss it!";
                $data = [
                    'sender' => 'System',
                    'content' => $notificationContent,
                    'user_id' => $userId,
                ];
                $this->notificationsRepo->insert($data);
            }
            $this->ticketManagementModel->markTicketsAsNotified($userId);
        }
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
    header("Location: " . $_SERVER['HTTP_REFERER']);
    die();
}