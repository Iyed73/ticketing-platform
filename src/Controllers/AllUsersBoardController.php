<?php
require_once("src/Models/UserRepo.php");
require_once("src/Models/EventRepo.php");

class AllUsersBoardController {
    private UserRepo $userRepo;
    public function __construct() {
        $this->userRepo = new UserRepo();
    }


    public function handleRequest($userID) {

        if (!$this->userRepo->isAdmin($userID)) {
            http_response_code(401);
            exit();
        }

        $totalPages = $this->userRepo->totalPagesNum();
        $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
        $offset = ($currentPage - 1) * 5;
        $allUsers = $this->userRepo->findWithOffset($offset, 5);

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
