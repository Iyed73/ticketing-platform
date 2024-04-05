<?php
require_once "src\Models\UserRepo.php";
require_once "src\Controllers\includes\configSession.inc.php";

class UserProfileController
{
    private $userTable;
    private $user;
    private $firstName;
    private $lastName;
    private $email;
    

    public function __construct()
    {
        $this->userTable = new UserRepo();
    }


    

    public function handleRequest()
    {
        require_once "src/Views/userProfile.php";
        die();
    }
}

$UserProfileController = new UserProfileController();
$UserProfileController->handleRequest();


