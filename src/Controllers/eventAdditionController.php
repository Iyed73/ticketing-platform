<?php

require_once ("src/Models/UserRepo.php");
require_once ("src/Models/EventRepo.php");
include 'prefix.php';

class eventAdditionController{
    private $name;
    private $venue;
    private $category;
    private $eventDate;
    private $shortDescription;
    private $longDescription;
    private $organizer;
    private $startSellTime;
    private $endSellTime;
    private $totalTickets;
    private $availableTickets;
    private $ticketPrice;

    public function __construct($name, $venue, $category, $eventDate, $shortDescription, $longDescription, $organizer, $startSellTime, $endSellTime,  $totalTickets, $availableTickets, $ticketPrice){
        $this -> name = $name;
        $this -> venue = $venue;
        $this -> category = $category;
        $this -> eventDate = $eventDate;
        $this -> shortDescription = $shortDescription;
        $this -> longDescription = $longDescription;
        $this -> organizer = $organizer;
        $this -> startSellTime = $startSellTime;
        $this -> endSellTime = $endSellTime;
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
        $this -> startSellTime = htmlspecialchars($this -> startSellTime);
        $this -> endSellTime = htmlspecialchars($this -> endSellTime);
        $this -> totalTickets = htmlspecialchars($this -> totalTickets);
        $this -> availableTickets = htmlspecialchars($this -> availableTickets);
        $this -> ticketPrice = htmlspecialchars($this -> ticketPrice);
    }

    public function is_input_empty() {
        return(empty($this -> name) || empty($this -> venue) || empty($this -> category) || empty($this -> eventDate) || empty($this -> shortDescription) || empty($this -> longDescription) || empty($this -> organizer) || empty($this -> startSellTime) || empty($this -> endSellTime) || empty($this -> totalTickets) || empty($this -> availableTickets) || empty($this -> ticketPrice));
    }

    public function is_name_taken(){
        $eventTable = new EventRepo();
        $event = $eventTable -> findByName($this -> name);
        if($event){
            return true;
        }
        return false;
    }

    public function is_eventDate_invalid() {
        $eventDateObj = new DateTime($this->eventDate);
        $startSellTimeObj = new DateTime($this->startSellTime);
        $endSellTimeObj = new DateTime($this->endSellTime);

        if ($eventDateObj < new DateTime('today') || $eventDateObj < $startSellTimeObj || $eventDateObj < $endSellTimeObj) {
            return true;
        } else {
            return false;
        }
    }

    public function is_startSellTime_invalid() {

        $startSellTimeObj = new DateTime($this->startSellTime);
        $endSellTimeObj = new DateTime($this->endSellTime);
        $eventDateObj = new DateTime($this->eventDate);

        if ($startSellTimeObj > $endSellTimeObj || $startSellTimeObj > $eventDateObj) {
            return true;
        } else {
            return false;
        }
    }

    public function is_endSellTime_invalid() {
        $endSellTimeObj = new DateTime($this->endSellTime);
        $startSellTimeObj = new DateTime($this->startSellTime);
        $eventDateObj = new DateTime($this->eventDate);

        if ($endSellTimeObj < $startSellTimeObj || $endSellTimeObj > $eventDateObj) {
            return true;
        } else {
            return false;
        }
    }

    public function addEvent(){
        $eventTable = new EventRepo();

        $eventTable -> insert([
            'name' => $this -> name,
            'venue' => $this -> venue,
            'category' => $this -> category,
            'eventDate' => $this -> eventDate,
            'shortDescription' => $this -> shortDescription,
            'longDescription' => $this -> longDescription,
            'organizer' => $this -> organizer,
            'startSellTime' => $this -> startSellTime,
            'endSellTime' => $this -> endSellTime,
            'totalTickets' => $this -> totalTickets,
            'availableTickets' => $this -> availableTickets,
            'ticketPrice' => $this -> ticketPrice,
        ]);
    }

    public function handleEventAdditionForm(){
        //EROOR HANDLING
        $errors = [];
        if($this -> is_input_empty()){
            $errors["empty_input"] = "<div class = 'alert alert-warning-dismissible fade show' role ='alert'>
                                        <strong> Fill in all fields!</strong>
                                        <button type = 'button' class = 'btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                                      </div>";
        }
        if($this -> is_name_taken()){
            $errors["name_taken"] = "<div class = 'alert alert-warning-dismissible fade show' role ='alert'>
                                        <strong> Name is already taken!</strong>
                                        <button type = 'button' class = 'btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                                      </div>";
        }

        if($this -> is_eventDate_invalid()){
            $errors["eventDate_inavlid"] = "<div class = 'alert alert-warning-dismissible fade show' role ='alert'>
                                        <strong> Your event date is invalid!</strong>
                                        <button type = 'button' class = 'btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                                      </div>";
        }

        if ($this->is_startSellTime_invalid()){
            $errors["startSellTime_invalid"] = "<div class = 'alert alert-warning-dismissible fade show' role ='alert'>
                                        <strong> Your start-sell time is invalid!</strong>
                                        <button type = 'button' class = 'btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                                      </div>";
        }

        if($this -> is_endSellTime_invalid()){
            $errors["endSellTime_invalid"] = "<div class = 'alert alert-warning-dismissible fade show' role ='alert'>
                                        <strong> Your end-sell time is invalid!</strong>
                                        <button type = 'button' class = 'btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                                      </div>";
        }

        //other error handling can be added here

        require_once("src/Controllers/includes/configSession.inc.php");

        if($errors){
            $_SESSION["eventAddition_errors"] = $errors;

            $eventAdditionData = [
                "name" => $this -> name,
                "venue" => $this -> venue,
                "category" => $this -> category,
                "eventDate" => $this -> eventDate,
                "shortDescription" => $this -> shortDescription,
                "longDescription" => $this -> longDescription,
                "organizer" => $this -> organizer,
                "startSellTime" => $this -> startSellTime,
                "endSellTime" => $this -> endSellTime,
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

    public function handleRequest($userID) {
        $userRepo = new UserRepo();
        if ($userRepo->isAdmin($userID)) {
            require_once "src/Views/EventAddition/eventAdditionView.php";
        } else {
            http_response_code(401);
            exit();
        }
    }
}


if($_SERVER["REQUEST_METHOD"] == "POST"){
    $eventAdditionController = new eventAdditionController($_POST["name"], $_POST["venue"], $_POST["category"], $_POST["eventDate"], $_POST["shortDescription"], $_POST["longDescription"], $_POST["organizer"], $_POST["startSellTime"], $_POST["endSellTime"], $_POST["totalTickets"], $_POST["availableTickets"], $_POST["ticketPrice"]);
    $eventAdditionController -> handleEventAdditionForm();
}

else{

    require_once "src/Views/EventAddition/eventAdditionView.php";

    if(!isset($_SESSION["user_id"])){
        http_response_code(401);
        exit();
    }
    else {

        $userRepo = new UserRepo();

        if($userRepo->isAdmin($_SESSION["user_id"]) === true){
            require_once "src/Views/EventAddition/eventAdditionView.php";
            die();
        }
        else{
            http_response_code(401);
            die();
        }
    }
}
