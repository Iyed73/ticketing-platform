<?php
require_once "src/utils.php";

class eventUpdateController{

    private EventModel $EventModel;

    public function __construct(){
        $this -> EventModel = new EventModel();
    }

    public function is_input_empty($name, $venue, $category, $eventDate, $shortDescription, $longDescription, $organizer, $startSellTime, $totalTickets, $availableTickets, $ticketPrice)
    {
        return (empty($name) || empty($venue) || empty($category) || empty($eventDate) || empty($shortDescription) || empty($longDescription) || empty($organizer) || empty($startSellTime) || empty($totalTickets) || empty($availableTickets) || empty($ticketPrice));
    }

    public function is_name_taken($name) {
        $eventTable = new EventModel();
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

    public function is_ticketNumber_invalid($availableTickets, $totalTickets){
        return $availableTickets > $totalTickets || $availableTickets < 0 || $totalTickets < 0;
    }

    public function categoryExists($categoryName){
        $categoryModel = new CategoryModel();
        return $categoryModel -> categoryExists($categoryName);
    }

    public function is_price_invalid($ticketPrice){
        return $ticketPrice <= 0;
    }


    public function updateEvent($Id, $name, $venue, $category, $eventDate, $shortDescription, $longDescription, $organizer, $startSellTime, $totalTickets, $availableTickets, $ticketPrice, $imagePath) {
        $eventTable = new EventModel();

        $eventTable->update([
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
            'imagePath' => $imagePath,
        ], $Id);
    }


    public function handleGetRequest($userID, $eventID){

        $UserModel = new UserModel();

        if($UserModel->isAdmin($userID) === true){

            $_SESSION['eventData'] = $this -> EventModel -> findById($eventID);

            require_once "src/Views/EventUpdate/eventUpdateView.php";

            die();
        }
        else{
            http_response_code(401);
            die();
        }
    }

    public function handlePostRequest($userID){
        $UserModel = new UserModel();

        if(!$UserModel->isAdmin($userID)){
            http_response_code(401);
            die();
        }

        $eventID = $_POST['id'];
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
        $targetFile = $_POST['imagePath'];

        $imagePath = $targetFile;

        if (!empty($_FILES['image']['name'])) {
            $targetDir = "Static/Images/";
            $targetFile = $targetDir . basename($_FILES["image"]["name"]);
            $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

            $imagePath = $targetDir . generateRandomImageName($imageFileType);

            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $fileMimeType = finfo_file($finfo, $_FILES["image"]["tmp_name"]);
            finfo_close($finfo);

            if (substr($fileMimeType, 0, 5) !== 'image') {
                $_SESSION['error'] = "File is not an image.";
                header("Location: event_update?id={$eventID}&eventUpdate=failed");
                die();
            }

            if ($_FILES["image"]["size"] > 500000) {
                $_SESSION['error'] = "Sorry, your file is too large.";
                header("Location: event_update?id={$eventID}&eventUpdate=failed");
                die();
            }

            if (!in_array($imageFileType, ["jpg", "jpeg", "png"])) {
                $_SESSION['error'] = "Sorry, only JPG, JPEG, PNG files are allowed.";
                header("Location: event_update?id={$eventID}&eventUpdate=failed");
                die();
            }

            if (!move_uploaded_file($_FILES["image"]["tmp_name"], $imagePath)) {
                $_SESSION['error'] = "Failed to upload image.";
                header("Location: event_update?id={$eventID}&eventUpdate=failed");
                die();
            }
        }


        if ($this->is_input_empty($name, $venue, $category, $eventDate, $shortDescription, $longDescription, $organizer, $startSellTime, $totalTickets, $availableTickets, $ticketPrice)){
            $_SESSION['error'] = "Fields must not be empty!";
            header("Location: event_update?id={$eventID}&eventUpdate=failed");
            die();
        }

        if($this->is_eventDate_invalid($eventDate, $startSellTime)){
            $_SESSION['error'] = "Event date not valid!";
            header("Location: event_update?id={$eventID}&eventUpdate=failed");
            die();
        }

        if($this->is_startSellTime_invalid($startSellTime, $eventDate)){
            $_SESSION['error'] = "Start Sell Time not valid!";
            header("Location: event_update?id={$eventID}&eventUpdate=failed");
            die();
        }

        if($this -> is_ticketNumber_invalid($availableTickets, $totalTickets)){
            $_SESSION['error'] = "Ticket Number is not valid!";
            header("Location: event_update?id={$eventID}&eventUpdate=failed");
            die();
        }

        if(!$this -> categoryExists($category)){
            $_SESSION['error'] = "Category not valid";
            header("Location: event_update?id={$eventID}&eventUpdate=failed");
            die();
        }

        if($this -> is_price_invalid($ticketPrice)){
            $_SESSION['error'] = "Price not valid";
            header("Location: event_update?id={$eventID}&eventUpdate=failed");
            die();
        }

        $this->updateEvent($eventID, $name, $venue, $category, $eventDate, $shortDescription, $longDescription, $organizer, $startSellTime, $totalTickets, $availableTickets, $ticketPrice, $imagePath);
        header("Location: all_events?eventUpdate=success");
        die();
    }
}

require_once "src/Controllers/includes/configSession.inc.php";

if (!isset($_SESSION["user_id"])) {
    http_response_code(401);
    exit();
}

$userID = $_SESSION["user_id"];

$eventUpdateController = new eventUpdateController();

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $eventUpdateController -> handlePostRequest($userID);
}

else if($_SERVER["REQUEST_METHOD"] == "GET"){

    if(!isset($_GET['id'])){
        header("Location: home");
        die();
    }

    $eventID = $_GET['id'];
    $eventUpdateController -> handleGetRequest($userID, $eventID);
}

