<?php

class EventAdditionController
{
    private EventModel $EventModel;

    public function __construct()
    {
        $this->EventModel = new EventModel();
    }

    public function isInputEmpty($name, $venue, $category, $eventDate, $shortDescription, $longDescription, $organizer, $startSellTime, $totalTickets, $availableTickets, $ticketPrice, $targetFile)
    {
        return (empty($name) || empty($venue) || empty($category) || empty($eventDate) || empty($shortDescription) || empty($longDescription) || empty($organizer) || empty($startSellTime) || empty($totalTickets) || empty($availableTickets) || empty($ticketPrice) || empty($targetFile));
    }

    public function isNameTaken($name)
    {
        $eventTable = new EventModel();
        $event = $eventTable->findByName($name);
        return $event !== null;
    }

    public function isEventDateInvalid($eventDate, $startSellTime)
    {
        $eventDateObj = new DateTime($eventDate);
        $startSellTimeObj = new DateTime($startSellTime);
        return $eventDateObj < new DateTime('today') || $eventDateObj < $startSellTimeObj;
    }

    public function isStartSellTimeInvalid($startSellTime, $eventDate)
    {
        $startSellTimeObj = new DateTime($startSellTime);
        $eventDateObj = new DateTime($eventDate);
        return $startSellTimeObj > $eventDateObj;
    }

    public function is_ticketNumber_invalid($availableTickets, $totalTickets){
        return $availableTickets > $totalTickets;
    }

    public function addEvent($name, $venue, $category, $eventDate, $shortDescription, $longDescription, $organizer, $startSellTime, $totalTickets, $availableTickets, $ticketPrice, $imagePath)
    {
        $this->EventModel->insert([
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
        ]);
    }

    public function handleGetRequest($userID)
    {
        $UserModel = new UserModel();
        if ($UserModel->isAdmin($userID)) {
            require_once "src/Views/EventAddition/eventAdditionView.php";
            die();
        } else {
            http_response_code(401);
            die();
        }
    }

    public function handlePostRequest($userID)
    {
        $UserModel = new UserModel();
        if (!$UserModel->isAdmin($userID)) {
            header("Location: home");
            die();
        }

        if (!isset($_FILES["image"]["name"]) || empty($_FILES["image"]["name"])) {
            $_SESSION['error'] = "Please select an image.";
            header("Location: event_addition?eventAddition=failed");
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

        $targetDir = "Static/Images/";
        $targetFile = $targetDir . basename($_FILES["image"]["name"]);
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));


        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $fileMimeType = finfo_file($finfo, $_FILES["image"]["tmp_name"]);
        finfo_close($finfo);

        $is_there_errors =  false;

        if ($this->isInputEmpty($name, $venue, $category, $eventDate, $shortDescription, $longDescription, $organizer, $startSellTime, $totalTickets, $availableTickets, $ticketPrice, $targetFile)) {
            $_SESSION['error'] = "Fields must not be empty!";
            $is_there_errors =  true;
            header("Location: event_addition?eventAddition=failed");
            die();
        }

        if ($this->isEventDateInvalid($eventDate, $startSellTime)) {
            $_SESSION['error'] = "Event date not valid!";
            $is_there_errors =  true;
            header("Location: event_addition?eventAddition=failed");
            die();
        }

        if ($this->isStartSellTimeInvalid($startSellTime, $eventDate)) {
            $_SESSION['error'] = "Start Sell Time not valid!";
            $is_there_errors =  true;
            header("Location: event_addition?eventAddition=failed");
            die();
        }

        if($this -> is_ticketNumber_invalid($availableTickets, $totalTickets)){
            $_SESSION['error'] = "Tickets Number not valid!";
            $is_there_errors =  true;
            header("Location: event_addition?eventAddition=failed");
            die();
        }

        if (substr($fileMimeType, 0, 5) !== 'image') {
            $_SESSION['error'] = "File is not an image.";
            $is_there_errors =  true;
            header("Location: event_addition?eventAddition=failed");
            die();
        }

        if ($_FILES["image"]["size"] > 500000) {
            $_SESSION['error'] = "Sorry, your file is too large.";
            $is_there_errors =  true;
            header("Location: event_addition?eventAddition=failed");
            die();
        }

        if (!in_array($imageFileType, ["jpg", "jpeg", "png"])) {
            $_SESSION['error'] = "Sorry, only JPG, JPEG, PNG files are allowed.";
            $is_there_errors =  true;
            header("Location: event_addition?eventAddition=failed");
            die();
        }

        if (!$is_there_errors && move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
            $this->addEvent($name, $venue, $category, $eventDate, $shortDescription, $longDescription, $organizer, $startSellTime, $totalTickets, $availableTickets, $ticketPrice, $targetFile);
            header("Location: all_events?eventAddition=success");
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

$eventAdditionController = new EventAdditionController();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $eventAdditionController->handlePostRequest($userID);
} else if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $eventAdditionController->handleGetRequest($userID);
}
