<?php
require_once "src\Models\EventRepo.php";
$prefix = $_ENV['prefix'];
class EventPageController {
    private $event;
    private $currentCategoryEvents;
    private $eventTable;

    public function __construct() {
        $this->eventTable = new EventRepo();
    }
    
    private function getData($prefix){
        if(!isset($_GET['id'])){
            $prefix = $_ENV['prefix'];
            header("Location: {$prefix}/");
            die();
        }

        $this->event = $this->eventTable->findById($_GET['id']);

        $this->currentCategoryEvents = $this->eventTable->getSimilarEvents($this->event->category, $this->event->id, 7);
    }
    
    public function handleRequest($prefix){
        $this->getData($prefix);
        require_once "src/Controllers/includes/configSession.inc.php";
        
        $_SESSION["event"] = serialize($this->event);
        $_SESSION["currentCategoryEvents"] = serialize($this->currentCategoryEvents);
        
        require_once "src/Views/eventPage.php";
        die();
    }
}

$eventPageController = new EventPageController();
$eventPageController->handleRequest($prefix);


