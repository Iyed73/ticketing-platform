<?php 
require_once "../Controllers/includes/configSession.inc.php";

// Retrieve and unserialize session variables
$events = unserialize($_SESSION["events"]) ?? [];
$categories = unserialize($_SESSION["categories"]) ?? [];
$eventsByCategory = unserialize($_SESSION["eventsByCategory"]) ?? [];

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Tickety - Event Booking Platform</title>
        <?php require_once 'Common/header.php' ?>
    </head>
    <body>
        <?php include 'Common/loadingSpinner.php' ?>


        <?php include 'Common/navbar.php' ?>


        <?php include 'Common/modalSearch.php' ?>


        <?php include 'Home/hero.php' ?>
        

        <?php include 'Home/eventSection.php' ?>
        

        <?php
        //If a category has no current events, do not display it
        foreach ($categories as $category) {
            if (isset($eventsByCategory[$category])) {
                include 'Home/eventCarousel.php';
                }
        }
        ?>
        

        <?php include 'Home/facts.php' ?>


        <?php include 'Home/testimonialSection.php' ?>


        <?php include 'Common/footer.php' ?>
        
        
        <?php include 'Common/copyright.php' ?>


        <?php include 'Common/backToTopButton.php' ?>
        
        
        <?php include 'Common/scripts.php'?>
    </body>

</html>
