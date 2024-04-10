<?php

class AllEventsBoardController {
    private UserModel $UserModel;
    private EventModel $EventModel;
    public function __construct() {
        $this->UserModel = new UserModel();
        $this->EventModel = new EventModel();
    }


    public function handleRequest($userID) {

        if (!$this->UserModel->isAdmin($userID)) {
            http_response_code(401);
            exit();
        }

        $totalPages = $this->EventModel->totalPagesNum();
        $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
        $offset = ($currentPage - 1) * 5;
        $allEvents = $this->EventModel->findWithOffset($offset, 5);

        if($allEvents == null){
            $allEvents = [];
        }

        require_once "src/Views/Dashboard/AllEventsBoard.php";

    }
}


if (!isset($_SESSION["user_id"])) {
    http_response_code(401);
    exit();
} else {
    $allEventsBoardController = new AllEventsBoardController();
    $allEventsBoardController->handleRequest($_SESSION["user_id"]);
}
