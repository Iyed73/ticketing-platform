<?php
require_once "src\Models\UserRepo.php";
require_once "src\Models\EventRepo.php";
require_once "src\Models\CategoryRepo.php";
require_once 'Services\rememberMeService.php';

class HomeController {
    public $events;
    public $categories;
    public $eventsByCategory;
    public $eventTable;
    public $categoryTable;
    public $userTable;

    public function __construct() {
        $this->eventTable = new EventRepo();
        $this->categoryTable = new CategoryRepo();
        $this->userTable = new UserRepo();
    }
    
    public function getData(){
        $this->events = $this->eventTable->findAll();
        $categories = $this->categoryTable->findAll();

        // Initialize eventsByCategory array
        $this->eventsByCategory = [];
        foreach ($categories as $category) {
            $this->categories[] = $category->name;
            $this->eventsByCategory[$category->name] = [];
        }

        // Group events by category
        foreach ($this->events as $event) {
            $this->eventsByCategory[$event->category][] = $event;
        }
    }

    public function handleRequest(){
        $this->getData();
        require_once "includes/configSession.inc.php";
        $_SESSION["events"] = serialize($this->events);
        $_SESSION["categories"] = serialize($this->categories);
        $_SESSION["eventsByCategory"] = serialize($this->eventsByCategory);

        // Log in user if he chose to be remembered
        $rememberMeService = new rememberMeService();
        if (isset($_COOKIE['remember_me'])) {
            $rememberMeService->LoginWithToken($_COOKIE['remember_me']);
        }
        
        require_once "src/Views/home.php";
        die();
    }
}

$homeController = new HomeController();
$homeController->handleRequest();


