<?php
require_once 'Services\rememberMeService.php';
require_once 'Services\CurrencyConverter.php';


class HomeController {
    public $events;
    public $categories;
    public $eventsByCategory;
    public $eventTable;
    public $categoryTable;
    public $userTable;
    private $currencyConverter;


    public function __construct() {
        $this->eventTable = new EventModel();
        $this->categoryTable = new CategoryModel();
        $this->userTable = new UserModel();
        $this->currencyConverter = new CurrencyConverter();
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

        if (isset($_SESSION['currency']) && $_SESSION['currency'] !== 'USD') {
            foreach ($this->events as $event) {
                $event->ticketPrice = $this->currencyConverter->convertPrice($event->ticketPrice, $_SESSION['currency']);
            }
        }

        $_SESSION["events"] = serialize($this->events);
        $_SESSION["categories"] = serialize($this->categories);
        $_SESSION["eventsByCategory"] = serialize($this->eventsByCategory);

        // Log in user if he chose to be remembered
        $rememberMeService = new rememberMeService();
        if (isset($_COOKIE['remember_me'])) {
            $rememberMeService->LoginWithToken($_COOKIE['remember_me']);
        }
        
        require_once "src/Views/Home/home.php";
        die();
    }
}

$homeController = new HomeController();
$homeController->handleRequest();


