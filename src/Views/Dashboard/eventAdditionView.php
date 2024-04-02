<?php

    function eventAdditionInput(){
        //fill input fields with data if it exists
        if(isset($_SESSION["eventAddition_data"]["name"])){
            echo '<div class = "row mb-3">
            <label class = "col-sm-3 col-form-label">Name</label>
            <div class = "col-sm-6">
                <input type = "text" class = "form-control" name = "name" value = "'. $_SESSION["eventAddition_data"]["name"].'">
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

        if(isset($_SESSION["eventAddition_data"]["venue"])){
            echo   '<div class = "row mb-3">
                        <label class = "col-sm-3 col-form-label">Venue</label>
                        <div class = "col-sm-6">
                            <input type = "text" class = "form-control" name = "venue" value = "'. $_SESSION["eventAddition_data"]["venue"].'">
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

        if(isset($_SESSION["eventAddition_data"]["eventDate"])){
            echo    '<div class = "row mb-3">
            <label class = "col-sm-3 col-form-label">Date</label>
            <div class = "col-sm-6">
                <input type = "date" class = "form-control" name = "eventDate" value = "'. $_SESSION["eventAddition_data"]["eventDate"].'">
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

        if(isset($_SESSION["eventAddition_data"]["shortDescription"])){
            echo    '<div class = "row mb-3">
            <label class = "col-sm-3 col-form-label">Short Description</label>
            <div class = "col-sm-6">
                <input type = "text" class = "form-control" name = "shortDescription" value = "'. $_SESSION["eventAddition_data"]["shortDescription"].'">
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

        if(isset($_SESSION["eventAddition_data"]["longDescription"])){
            echo    '<div class = "row mb-3">
            <label class = "col-sm-3 col-form-label">Long Description</label>
            <div class = "col-sm-6">
                <input type = "text" class = "form-control" name = "longDescription" value = "'. $_SESSION["eventAddition_data"]["longDescription"].'">
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

        if(isset($_SESSION["eventAddition_data"]["organizer"])){
            echo    '<div class = "row mb-3">
            <label class = "col-sm-3 col-form-label">Organizer</label>
            <div class = "col-sm-6">
                <input type = "text" class = "form-control" name = "organizer" value = "'. $_SESSION["eventAddition_data"]["organizer"].'">
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

        if(isset($_SESSION["eventAddition_data"]["totalTickets"])){
            echo    '<div class = "row mb-3">
            <label class = "col-sm-3 col-form-label">Total Tickets</label>
            <div class = "col-sm-6">
                <input type = "number" class = "form-control" name = "totalTickets" value = "'. $_SESSION["eventAddition_data"]["totalTickets"].'">
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

        if(isset($_SESSION["eventAddition_data"]["availableTickets"])){
            echo    '<div class = "row mb-3">
            <label class = "col-sm-3 col-form-label">Available Tickets</label>
            <div class = "col-sm-6">
                <input type = "number" class = "form-control" name = "availableTickets" value = "'. $_SESSION["eventAddition_data"]["availableTickets"].'">
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

        if(isset($_SESSION["eventAddition_data"]["ticketPrice"])){
            echo    '<div class = "row mb-3">
            <label class = "col-sm-3 col-form-label">Ticket Price</label>
            <div class = "col-sm-6">
                <input type = "number" class = "form-control" name = "ticketPrice" value = "'. $_SESSION["eventAddition_data"]["ticketPrice"].'">
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

        unset($_SESSION["eventAddition_data"]);
    }

    function checkEventAdditionErrors(){
        if(isset($_SESSION["eventAddition_errors"])){
            $errors = $_SESSION["eventAddition_errors"];
            echo "<br>";
            foreach ($errors as $error){
                echo "<p class=error-message>$error</p>";
            }
        }

        unset($_SESSION["eventAddition_errors"]);
    }

    function checkEventAdditionSuccess(){
        if(isset($_GET["eventAddition"])){
            if($_GET["eventAddition"]=="success"){
                echo "<p class=success-message>Event added successfully!</p>";
            }

        }
    }
