<?php

    function addEventInput(){
        //fill input fields with data if it exists
        if(isset($_SESSION["addEvent_data"]["name"])){
            echo '<div class = "row mb-3">
            <label class = "col-sm-3 col-form-label">Name</label>
            <div class = "col-sm-6">
                <input type = "text" class = "form-control" name = "name" value = "'. $_SESSION["addEvent_data"]["name"].'">
            </div>
        </div>';
        }

        else{
            echo '<div class = "row mb-3">
                    <label class = "col-sm-3 col-form-label">Name</label>
                    <div class = "col-sm-6">
                        <input type = "text" class = "form-control" name = "name" value = "">
                    </div>
                </div>';
        }

        if(isset($_SESSION["addEvent_data"]["venue"])){
            echo   '<div class = "row mb-3">
                        <label class = "col-sm-3 col-form-label">Venue</label>
                        <div class = "col-sm-6">
                            <input type = "text" class = "form-control" name = "venue" value = "'. $_SESSION["addEvent_data"]["venue"].'">
                        </div>
                    </div>';
        }
        else{
            echo '<div class = "row mb-3">
                        <label class = "col-sm-3 col-form-label">Venue</label>
                        <div class = "col-sm-6">
                            <input type = "text" class = "form-control" name = "venue" value = "">
                        </div>
                  </div>';
        }

        if(isset($_SESSION["addEvent_data"]["eventDate"])){
            echo    '<div class = "row mb-3">
            <label class = "col-sm-3 col-form-label">Date</label>
            <div class = "col-sm-6">
                <input type = "date" class = "form-control" name = "eventDate" value = "'. $_SESSION["addEvent_data"]["eventDate"].'">
            </div>
        </div>';

        }
        else{
            echo '<div class = "row mb-3">
            <label class = "col-sm-3 col-form-label">Date</label>
            <div class = "col-sm-6">
                <input type = "date" class = "form-control" name = "eventDate" value = "">
            </div>
        </div>';
        }

        if(isset($_SESSION["addEvent_data"]["shortDescription"])){
            echo    '<div class = "row mb-3">
            <label class = "col-sm-3 col-form-label">Short Description</label>
            <div class = "col-sm-6">
                <input type = "text" class = "form-control" name = "shortDescription" value = "'. $_SESSION["addEvent_data"]["shortDescription"].'">
            </div>
        </div>';

        }
        else{
            echo    '<div class = "row mb-3">
            <label class = "col-sm-3 col-form-label">Short Description</label>
            <div class = "col-sm-6">
                <input type = "text" class = "form-control" name = "shortDescription" value = "">
            </div>
        </div>';
        }

        if(isset($_SESSION["addEvent_data"]["longDescription"])){
            echo    '<div class = "row mb-3">
            <label class = "col-sm-3 col-form-label">Long Description</label>
            <div class = "col-sm-6">
                <input type = "text" class = "form-control" name = "longDescription" value = "'. $_SESSION["addEvent_data"]["longDescription"].'">
            </div>
        </div>';
        }
        else{
            echo    '<div class = "row mb-3">
            <label class = "col-sm-3 col-form-label">Long Description</label>
            <div class = "col-sm-6">
                <input type = "text" class = "form-control" name = "longDescription" value = "">
            </div>
        </div>';
        }

        if(isset($_SESSION["addEvent_data"]["organizer"])){
            echo    '<div class = "row mb-3">
            <label class = "col-sm-3 col-form-label">Organizer</label>
            <div class = "col-sm-6">
                <input type = "text" class = "form-control" name = "organizer" value = "'. $_SESSION["addEvent_data"]["organizer"].'">
            </div>
        </div>';
        }
        else{
            echo    '<div class = "row mb-3">
            <label class = "col-sm-3 col-form-label">Organizer</label>
            <div class = "col-sm-6">
                <input type = "text" class = "form-control" name = "organizer" value = "">
            </div>
        </div>';
        }

        if(isset($_SESSION["addEvent_data"]["totalTickets"])){
            echo    '<div class = "row mb-3">
            <label class = "col-sm-3 col-form-label">Total Tickets</label>
            <div class = "col-sm-6">
                <input type = "number" class = "form-control" name = "totalTickets" value = "'. $_SESSION["addEvent_data"]["totalTickets"].'">
            </div>
        </div>';
        }
        else{
            echo    '<div class = "row mb-3">
            <label class = "col-sm-3 col-form-label">Total Tickets</label>
            <div class = "col-sm-6">
                <input type = "number" class = "form-control" name = "totalTickets" value = "">
            </div>
        </div>';
        }

        if(isset($_SESSION["addEvent_data"]["availableTickets"])){
            echo    '<div class = "row mb-3">
            <label class = "col-sm-3 col-form-label">Available Tickets</label>
            <div class = "col-sm-6">
                <input type = "number" class = "form-control" name = "availableTickets" value = "'. $_SESSION["addEvent_data"]["availableTickets"].'">
            </div>
        </div>';

        }
        else{
            echo    '<div class = "row mb-3">
            <label class = "col-sm-3 col-form-label">Available Tickets</label>
            <div class = "col-sm-6">
                <input type = "number" class = "form-control" name = "availableTickets" value = "">
            </div>
        </div>';
        }

        if(isset($_SESSION["addEvent_data"]["ticketPrice"])){
            echo    '<div class = "row mb-3">
            <label class = "col-sm-3 col-form-label">Ticket Price</label>
            <div class = "col-sm-6">
                <input type = "number" class = "form-control" name = "ticketPrice" value = "'. $_SESSION["addEvent_data"]["ticketPrice"].'">
            </div>
        </div>';
        }
        else{
            echo    '<div class = "row mb-3">
            <label class = "col-sm-3 col-form-label">Ticket Price</label>
            <div class = "col-sm-6">
                <input type = "number" class = "form-control" name = "ticketPrice" value = "">
            </div>
        </div>';
        }

        unset($_SESSION["addEvent_data"]);
    }

    function checkAddEventErrors(){
        if(isset($_SESSION["addEvent_errors"])){
            $errors = $_SESSION["addEvent_errors"];
            echo "<br>";
            foreach ($errors as $error){
                echo "<p class=error-message>$error</p>";
            }
        }

        unset($_SESSION["addEvent_errors"]);
    }

    function checkAddEventSuccess(){
        if(isset($_GET["addEvent"])){
            if($_GET["addEvent"]=="success"){
                echo "<p class=success-message>Event added successfully!</p>";
            }

        }
    }
