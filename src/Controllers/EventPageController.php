<?php
require_once "src\Models\EventRepo.php";

class EventPageController {
    private $event;
    private $currentCategoryEvents;
    private $eventTable;

    public function __construct() {
        $this->eventTable = new EventRepo();
    }
    
    private function getData(){
        if(!isset($_GET['id'])){
            header("Location: home");
            die();
        }

        $this->event = $this->eventTable->findById($_GET['id']);

        if ($this->event === false) {
            header("Location: home");
            die();
        }

        $this->currentCategoryEvents = $this->eventTable->getEventsByCategory($this->event->category);
    }
    
    public function handleRequest(){
        $this->getData();
        require_once "src/Controllers/includes/configSession.inc.php";
        
        $_SESSION["event"] = serialize($this->event);
        $_SESSION["currentCategoryEvents"] = serialize($this->currentCategoryEvents);
        
        require_once "src/Views/eventPage.php";
        die();
    }
}

$eventPageController = new EventPageController();
$eventPageController->handleRequest();


