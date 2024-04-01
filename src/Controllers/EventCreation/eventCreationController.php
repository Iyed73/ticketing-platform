<?php
require_once("../../Models/EventRepo.php");
class eventCreationController {
    private $name;
    private $venue;
    private $organizer;
    private $eventDate;
    private $shortDescription;
    private $longDescription;
    private $totalTickets;
    private $availableTickets;
    private $startSellTime;
    private $endSellTime;
    private $ticketPrice;
    private $category;
    private $imagePath;

    

    public function __construct($name, $venue, $organizer, $eventDate, $shortDescription,
     $longDescription, $totalTickets, $availableTickets, $startSellTime,
      $endSellTime, $ticketPrice, $category, $imagePath) {
        $this->name = $name;
        $this->venue = $venue;
        $this->organizer = $organizer;
        $this->eventDate = $eventDate;
        $this->shortDescription = $shortDescription;
        $this->longDescription = $longDescription;
        $this->totalTickets = $totalTickets;
        $this->availableTickets = $availableTickets;
        $this->startSellTime = $startSellTime;
        $this->endSellTime = $endSellTime;
        $this->ticketPrice = $ticketPrice;
        $this->category = $category;
        $this->imagePath = $imagePath;
    }
    
    public function sanitizeInput() {
        $this->name = htmlspecialchars($this->name);
        $this->venue = htmlspecialchars($this->venue);
        $this->organizer = htmlspecialchars($this->organizer);
        $this->eventDate = htmlspecialchars($this->eventDate);
        $this->shortDescription = htmlspecialchars($this->shortDescription);
        $this->longDescription = htmlspecialchars($this->longDescription);
        $this->totalTickets = htmlspecialchars($this->totalTickets);
        $this->availableTickets = htmlspecialchars($this->availableTickets);
        $this->startSellTime = htmlspecialchars($this->startSellTime);
        $this->endSellTime = htmlspecialchars($this->endSellTime);
        $this->ticketPrice = htmlspecialchars($this->ticketPrice);
        $this->category = htmlspecialchars($this->category);
        $this->imagePath = htmlspecialchars($this->imagePath);
    }
    
    public function is_input_empty() {
        return(
            empty($this->name) ||
            empty($this->venue) ||
            empty($this->organizer) ||
            empty($this->eventDate) ||
            empty($this->shortDescription) ||
            empty($this->longDescription) ||
            empty($this->totalTickets) ||
            empty($this->availableTickets) ||
            empty($this->startSellTime) ||
            empty($this->endSellTime) ||
            empty($this->ticketPrice) ||
            empty($this->category) ||
            empty($this->imagePath)
        );
    }


    
    public function is_eventDate_invalid() {
        /*TODO*/
    }

    public function is_startSellTime_invalid() {
        /*TODO*/
    }

    public function is_endSellTime_invalid() {
        /*TODO*/
    }

    public function is_name_taken() {
        $eventTable = new EventRepo();
        $event = $eventTable->findByName($this->name);
        if($event) {
            return true;
        }
        return false;
    }

    public function addEvent() {
        $eventTable = new EventRepo();
        
        
        $eventTable->insert([
            'name' => $this->name,
            'venue' => $this->venue,
            'organizer' => $this->organizer,
            'eventDate' => $this->eventDate,
            'shortDescription' => $this->shortDescription,
            'longDescription' => $this->longDescription,
            'totalTickets' => $this->totalTickets,
            'availableTickets' => $this->availableTickets,
            'startSellTime' => $this->startSellTime,
            'endSellTime' => $this->endSellTime,
            'ticketPrice' => $this->ticketPrice,
            'category' => $this->category,
            'imagePath' => $this->imagePath,
        ]);
    }
}
