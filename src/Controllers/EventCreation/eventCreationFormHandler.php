<?php
require_once("eventCreationController.php");
if($_SERVER["REQUEST_METHOD"]=="POST"){
    $eventController = new eventCreationController(
        $_POST["name"],
        $_POST["venue"],
        $_POST["organizer"],
        $_POST["eventDate"],
        $_POST["shortDescription"],
        $_POST["longDescription"],
        $_POST["totalTickets"],
        $_POST["availableTickets"],
        $_POST["startSellTime"],
        $_POST["endSellTime"],
        $_POST["ticketPrice"],
        $_POST["category"],
    );
    $eventController->sanitizeInput();

    //ERROR HANDLING
    $errors = [];

    if($eventController->is_input_empty()){
        $errors["empty_input"] = "Fill in all fields!";
    }
    if($eventController->is_eventDate_invalid() ||
        $eventController->is_startSellTime_invalid() ||
        $eventController->is_endSellTime_invalid()){
        $errors["invalid_date"] = "Invalid date provided!";
    }
    if($eventController->is_name_taken()){
        $errors["name_taken"] = "Event name already exists!";
    }
    //other error handling can be added here


    if($errors){
        $_SESSION["event_creation_errors"] = $errors;
        
        $eventData = [
            "name" => $_POST["name"],
            "venue" => $_POST["venue"],
            "organizer" => $_POST["organizer"],
            "eventDate" => $_POST["eventDate"],
            "shortDescription" => $_POST["shortDescription"],
            "longDescription" => $_POST["longDescription"],
            "totalTickets" => $_POST["totalTickets"],
            "availableTickets" => $_POST["availableTickets"],
            "startSellTime" => $_POST["startSellTime"],
            "endSellTime" => $_POST["endSellTime"],
            "ticketPrice" => $_POST["ticketPrice"],
            "category" => $_POST["category"],
        ];
        $_SESSION["event_creation_data"] = $signupData;

        header("Location: ../Views/eventCreate.php");
        die();
    }

    //If there are no errors, create a new event

    $eventController->addEvent();
    header("Location: ../Views/dashboard.php?event_create=success");
    die();
}else{
    header("Location: ../Views/dashboard.php");
    die();
}