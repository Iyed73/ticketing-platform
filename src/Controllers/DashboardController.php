<?php
require_once("src/Models/UserRepo.php");


class DashboardController {

    private UserRepo $userModel;


    public function __construct() {
        $this->userModel = new UserRepo();
    }

    public function handleRequest() {
        if (!isset($_SESSION["user_id"])) {
            http_response_code(401);
            exit();
        }
        $userId = $_SESSION["user_id"];
        if (!$this->userModel->isAdmin($userId)) {
            http_response_code(401);
            exit();
        }
        require_once "src/Views/dashboardView.php";
        exit();
    }
}

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    $controller = new DashboardController();
    $controller->handleRequest();
} else {
    http_response_code(400);
    exit();
}



