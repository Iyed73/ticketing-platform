<?php

require_once ("src/Models/UserRepo.php");
require_once ("src/Models/EventRepo.php");
include 'prefix.php';

class eventAdditionController{
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
            'ticketPrice' => $this -> ticketPrice,
            'category' => "Theater",
        ]);
    }

    public function handleEventAdditionForm(){
        //EROOR HANDLING
        $errors = [];
        if($this -> is_input_empty()){
            $errors["empty_input"] = "Fill in all fields!";
        }
        if($this -> is_name_taken()){
            $errors["name_taken"] = "Name already taken!";
        }

        //other error handling can be added here

        require_once("src/Controllers/includes/configSession.inc.php");

        if($errors){
            $_SESSION["eventAddition_errors"] = $errors;

            $eventAdditionData = [
                "name" => $this -> name,
                "venue" => $this -> venue,
                "eventDate" => $this -> eventDate,
                "shortDescription" => $this -> shortDescription,
                "longDescription" => $this -> longDescription,
                "organizer" => $this -> organizer,
                "totalTickets" => $this -> totalTickets,
                "availableTickets" => $this -> availableTickets,
                "ticketPrice" => $this -> ticketPrice
            ];

            $_SESSION["eventAddition_data"] = $eventAdditionData;

            header("Location: /ticketing-platform/event_addition?eventAddition=failed");
            die();
        }

        $this -> addEvent();
        header("Location: /ticketing-platform/dashboard?eventAddition=success");
        die();
    }

    function handleRequest($userID)
    {

    }
}


if($_SERVER["REQUEST_METHOD"] == "POST"){
    $eventAdditionController = new eventAdditionController($_POST["name"], $_POST["venue"], $_POST["eventDate"], $_POST["shortDescription"], $_POST["longDescription"], $_POST["organizer"], $_POST["totalTickets"], $_POST["availableTickets"], $_POST["ticketPrice"]);
    $eventAdditionController -> handleEventAdditionForm();
}

else{

    require_once "src/Views/Dashboard/eventAdditionForm.php";

    if(!isset($_SESSION["user_id"])){
        http_response_code(401);
        exit();
    }
    else {

        $userRepo = new UserRepo();

        if($this->userRepo->isAdmin($_GET["user_id"]) === true){
            require_once "src/Views/Dashboard/eventAdditionForm.php";
            die();
        }
        else{
            http_response_code(401);
            die();
        }
    }
}
