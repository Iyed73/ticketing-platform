<?php
    require_once("addEventController.php");

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $addEventController = new addEventController($_POST["name"], $_POST["venue"], $_POST["eventDate"], $_POST["shortDescription"], $_POST["longDescription"], $_POST["organizer"], $_POST["totalTickets"], $_POST["availableTickets"], $_POST["ticketPrice"]);
        $addEventController -> sanitizeInput();

        //ERROR HANDLING
        $errors = [];

        if($addEventController -> is_input_empty()){
            $errors["empty_input"] = "Fill in all fields";
        }

        if($addEventController -> is_name_taken()){
            $errors["name_taken"] = "Name is already taken";
        }

        require_once("includes/configSession.inc.php");

        if($errors){
            $_SESSION["addEvent_errors"] = $errors;

            $addEventData = [
                "name" => $_POST["name"],
                "venue" => $_POST["venue"],
                "eventDate" => $_POST["eventDate"],
                "shortDescription" => $_POST["shortDescription"],
                "longDescription" => $_POST["longDescription"],
                "organizer" => $_POST["organizer"],
                "totalTickets" => $_POST["totalTickets"],
                "availableTickets" => $_POST["availableTickets"],
                "ticketPrice" => $_POST["ticketPrice"]
            ];

            $_SESSION["addEvent_data"] = $addEventData;

            header("Location: ../Views/addEventForm.php");
            die();
        }

        //If there are no errors, create a new event

        $addEventController -> addEvent();
        header("Location: ../Views/Dashboard/adminDashboard.php");
        die();
    }

    else{
        header("Location: ../Views/Dashboard/addEventForm.php");
        die();
    }


