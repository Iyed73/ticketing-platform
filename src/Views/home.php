<?php 
require_once "src/Controllers/includes/configSession.inc.php";

// Retrieve and unserialize session variables
$events = unserialize($_SESSION["events"]) ?? [];
$categories = unserialize($_SESSION["categories"]) ?? [];
$eventsByCategory = unserialize($_SESSION["eventsByCategory"]) ?? [];

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Tickety - Event Booking Platform</title>
        <?php require_once 'header.php' ?>
    </head>
    <body>
        <?php include 'loadingSpinner.php' ?>


        <?php include 'navbar.php' ?>


        <?php include 'modalSearch.php' ?>


        <?php include 'home/hero.php' ?>
        

        <?php include 'home/eventSection.php' ?>
        

        <?php //include 'src/Views/home/featuresSection.php' ?>


        <?php
        //If a category has no current events, do not display it
        foreach ($categories as $category) {
            if (isset($eventsByCategory[$category])) {
                include 'home/eventCarousel.php';
                }
        }
        ?>
        

        <?php //include 'src/Views/home/bannerSection.php' ?>
        

        <?php //include 'src/Views/home/bestSellerSection.php' ?>
        

        <?php //include 'src/Views/home/factsSection.php' ?>


        <?php include 'home/anotherFeatureSection.php' ?>


        <?php include 'home/testimonialSection.php' ?>


        <?php include 'footer.php' ?>
        
        
        <?php include 'copyright.php' ?>


        <?php include 'backToTopButton.php' ?>
        
        
        <?php include 'scripts.php'?>
    </body>

</html>
