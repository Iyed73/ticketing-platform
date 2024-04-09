<?php


class AllUsersBoardController {
    private UserModel $UserModel;
    public function __construct() {
        $this->UserModel = new UserModel();
    }


    public function handleRequest($userID) {

        if (!$this->UserModel->isAdmin($userID)) {
            http_response_code(401);
            exit();
        }

        $totalPages = $this->UserModel->totalPagesNum();
        $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
        $offset = ($currentPage - 1) * 5;
        $allUsers = $this->UserModel->findWithOffset($offset, 5);

        if($allUsers == null){
            $allUsers = [];
        }

        require_once "src/Views/Dashboard/AllUsersBoard.php";

    }
}

require_once "src/Controllers/includes/configSession.inc.php";

if (!isset($_SESSION["user_id"])) {
    http_response_code(401);
    exit();
} else {
    $allUsersBoardController = new AllUsersBoardController();
    $allUsersBoardController->handleRequest($_SESSION["user_id"]);
}
