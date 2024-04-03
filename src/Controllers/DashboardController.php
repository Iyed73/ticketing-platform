<?php
require_once ("src/Models/UserRepo.php");
class DashboardController{

    private UserRepo $userRepo;

    public function __construct(){
        $this -> userRepo = new UserRepo();
    }
    function handleRequest($userID)
    {
        if($this->userRepo->isAdmin($userID) === true){
            require_once "src/Views/Dashboard/adminDashboard.php";
            die();
        }
        else{
            http_response_code(401);
            die();
        }
    }
}

require_once "src/Controllers/includes/configSession.inc.php";

if(!isset($_SESSION["user_id"])){
    http_response_code(401);
    exit();
}
else {
    $dashboardController = new DashboardController();
    $dashboardController->handleRequest($_SESSION["user_id"]);
}


