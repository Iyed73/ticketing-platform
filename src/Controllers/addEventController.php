<?php
require_once ("../Models/EventRepo.php");
class addEventController
{
    private $name;
    private $venue;
    private $eventDate;
    private $shortDescription;
    private $longDescription;
    private $organizer;
    private $totalTickets;
    private $availableTickets;
    private $ticketPrice;

    public function __construct($name, $venue, $eventDate, $shortDescription, $longDescription, $organizer, $totalTickets, $availableTickets, $ticketPrice){
        $this -> name = $name;
        $this -> venue = $venue;
        $this -> eventDate = $eventDate;
        $this -> shortDescription = $shortDescription;
        $this -> longDescription = $longDescription;
        $this -> organizer = $organizer;
        $this -> totalTickets = $totalTickets;
        $this -> availableTickets = $availableTickets;
        $this -> ticketPrice = $ticketPrice;
    }

    public function sanitizeInput() {
        $this -> name = htmlspecialchars($this -> name);
        $this -> venue = htmlspecialchars($this -> venue);
        $this -> eventDate = htmlspecialchars($this -> eventDate);
        $this -> shortDescription = htmlspecialchars($this -> shortDescription);
        $this -> longDescription = htmlspecialchars($this -> longDescription);
        $this -> organizer = htmlspecialchars($this -> organizer);
        $this -> totalTickets = htmlspecialchars($this -> totalTickets);
        $this -> availableTickets = htmlspecialchars($this -> availableTickets);
        $this -> ticketPrice = htmlspecialchars($this -> ticketPrice);
    }

    public function is_input_empty() {
        return(empty($this -> name) || empty($this -> venue) || empty($this -> eventDate) || empty($this -> shortDescription) || empty($this -> longDescription) || empty($this -> organizer) || empty($this -> totalTickets) || empty($this -> availableTickets) || empty($this -> ticketPrice));
    }

    public function is_name_taken(){
        $eventTable = new EventRepo();
        $event = $eventTable -> findByName($this -> name);
        if($event){
            return true;
        }
        return false;
    }

    public function addEvent(){
        $eventTable = new EventRepo();

        $eventTable -> insert([
            'name' => $this -> name,
            'venue' => $this -> venue,
            'eventDate' => $this -> eventDate,
            'shortDescription' => $this -> shortDescription,
            'longDescription' => $this -> longDescription,
            'organizer' => $this -> organizer,
            'totalTickets' => $this -> totalTickets,
            'availableTickets' => $this -> availableTickets,
            'ticketPrice' => $this -> ticketPrice
        ]);
    }

}