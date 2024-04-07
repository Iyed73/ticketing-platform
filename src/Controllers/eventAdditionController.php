<?php

    require_once "src/Models/EventRepo.php";
    require_once "src/Models/UserRepo.php";
    class eventAdditionController{

        private EventRepo $eventRepo;

        public function __construct(){
            $this -> eventRepo = new EventRepo();
        }

        public function is_input_empty($name, $venue, $category, $eventDate, $shortDescription, $longDescription, $organizer, $startSellTime, $totalTickets, $availableTickets, $ticketPrice) {
            return (empty($name) || empty($venue) || empty($category) || empty($eventDate) || empty($shortDescription) || empty($longDescription) || empty($organizer) || empty($startSellTime) || empty($totalTickets) || empty($availableTickets) || empty($ticketPrice));
        }

        public function is_name_taken($name) {
            $eventTable = new EventRepo();
            $event = $eventTable->findByName($name);
            if ($event) {
                return true;
            }
            return false;
        }

        public function is_eventDate_invalid($eventDate, $startSellTime) {
            $eventDateObj = new DateTime($eventDate);
            $startSellTimeObj = new DateTime($startSellTime);

            if ($eventDateObj < new DateTime('today') || $eventDateObj < $startSellTimeObj) {
                return true;
            } else {
                return false;
            }
        }

        public function is_startSellTime_invalid($startSellTime, $eventDate) {
            $startSellTimeObj = new DateTime($startSellTime);
            $eventDateObj = new DateTime($eventDate);

            if ($startSellTimeObj > $eventDateObj) {
                return true;
            } else {
                return false;
            }
        }


        public function addEvent($name, $venue, $category, $eventDate, $shortDescription, $longDescription, $organizer, $startSellTime, $totalTickets, $availableTickets, $ticketPrice) {
            $eventTable = new EventRepo();

            $eventTable->insert([
                'name' => $name,
                'venue' => $venue,
                'category' => $category,
                'eventDate' => $eventDate,
                'shortDescription' => $shortDescription,
                'longDescription' => $longDescription,
                'organizer' => $organizer,
                'startSellTime' => $startSellTime,
                'totalTickets' => $totalTickets,
                'availableTickets' => $availableTickets,
                'ticketPrice' => $ticketPrice,
            ]);
        }


        public function handleGetRequest($userID){

            require_once "src/Views/EventAddition/eventAdditionView.php";

            $userRepo = new UserRepo();

            if($userRepo->isAdmin($userID) === true){
                require_once "src/Views/EventAddition/eventAdditionView.php";
                die();
            }
            else{
                http_response_code(401);
                die();
            }
        }

        public function handlePostRequest($userID){

            $userRepo = new UserRepo();

            if(!$userRepo->isAdmin($userID)){
                header("Location: home");
                die();
            }

            $name = $_POST['name'];
            $venue = $_POST['venue'];
            $category = $_POST['category'];
            $eventDate = $_POST['eventDate'];
            $shortDescription = $_POST['shortDescription'];
            $longDescription = $_POST['longDescription'];
            $organizer = $_POST['organizer'];
            $startSellTime = $_POST['startSellTime'];
            $totalTickets = $_POST['totalTickets'];
            $availableTickets = $_POST['availableTickets'];
            $ticketPrice = $_POST['ticketPrice'];

            $is_There_Errors = false;


            if ($this -> is_input_empty($name, $venue, $category, $eventDate, $shortDescription, $longDescription, $organizer, $startSellTime, $totalTickets, $availableTickets, $ticketPrice)){
                $_SESSION['error'] = "Fields must not be empty!";
                $is_There_Errors = true;
                header("Location: /ticketing-platform/event_addition?eventAddition=failed");
            }

            if($this -> is_eventDate_invalid($eventDate, $startSellTime)){
                $_SESSION['error'] = "Event date not valid!";
                $is_There_Errors = true;
                header("Location: /ticketing-platform/event_addition?eventAddition=failed");
            }

            if($this -> is_startSellTime_invalid($startSellTime, $eventDate)){
                $_SESSION['error'] = "Start Sell Time not valid!";
                $is_There_Errors = true;
                header("Location: /ticketing-platform/event_addition?eventAddition=failed");
            }


            if(!$is_There_Errors){
                $this->addEvent($name, $venue, $category, $eventDate, $shortDescription, $longDescription, $organizer, $startSellTime, $totalTickets, $availableTickets, $ticketPrice);
                header("Location: /ticketing-platform/all_events?eventAddition=success");
                die();
            }





        }



    }

    require_once "src/Controllers/includes/configSession.inc.php";

    if (!isset($_SESSION["user_id"])) {
        http_response_code(401);
        exit();
    }

    $userID = $_SESSION["user_id"];

    $eventAdditionController2 = new eventAdditionController();

    if($_SERVER["REQUEST_METHOD"] == "POST"){

        $eventAdditionController2 -> handlePostRequest($userID);
    }

    else if($_SERVER["REQUEST_METHOD"] == "GET"){
        $eventAdditionController2 -> handleGetRequest($userID);
    }

