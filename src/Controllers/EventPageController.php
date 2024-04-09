<?php
require_once "src\Models\EventRepo.php";
require_once 'Services\CurrencyConverter.php';



$prefix = $_ENV['prefix'];
class EventPageController {
    private $event;
    private $currentCategoryEvents;
    private $eventTable;
    private $currencyConverter;

    public function __construct() {
        $this->eventTable = new EventRepo();
        $this->currencyConverter = new CurrencyConverter();
    }
    
    private function getData($prefix){
        if(!isset($_GET['id'])){
            header("Location: home");
            die();
        }

        $this->event = $this->eventTable->findById($_GET['id']);

        if ($this->event === false) {
            header("Location: home");
            die();
        }
        if (isset($_SESSION['currency']) && $_SESSION['currency'] !== 'USD') {
            $this->event->ticketPrice = $this->currencyConverter->convertPrice($this->event->ticketPrice, $_SESSION['currency']);
        }

        $this->currentCategoryEvents = $this->eventTable->getSimilarEvents($this->event->category, $this->event->id, 7);
    }
    
    public function handleRequest($prefix){
        $this->getData($prefix);
                
        $_SESSION["event"] = serialize($this->event);
        $_SESSION["currentCategoryEvents"] = serialize($this->currentCategoryEvents);
        
        require_once "src/Views/eventPage.php";
        die();
    }
}

$eventPageController = new EventPageController();
$eventPageController->handleRequest($prefix);


