<?php

class DashboardController {

    private UserModel $userModel;


    public function __construct() {
        $this->userModel = new UserModel();
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
        require_once "src/Views/Dashboard/dashboardView.php";
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



