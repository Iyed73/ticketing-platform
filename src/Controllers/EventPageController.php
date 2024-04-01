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
            header("Location: /");
            die();
        }

        $this->event = $this->eventTable->findById($_GET['id']);

        $this->currentCategoryEvents = $this->eventTable->getSimilarEvents($this->event->category, $this->event->id, 7);
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


