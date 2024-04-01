<?php 
require_once "src/Controllers/includes/configSession.inc.php";

// Retrieve and unserialize session variables
$events = unserialize($_SESSION["events"]) ?? [];
$categories = unserialize($_SESSION["categories"]) ?? [];
$eventsByCategory = unserialize($_SESSION["eventsByCategory"]) ?? [];
$pathToComponents = 'src/Views/';
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Tickety - Event Booking Platform</title>
        <?php require_once "{$pathToComponents}Common/header.php" ?>
    </head>
    <body>
        <?php 
        
             require_once "{$pathToComponents}Common/loadingSpinner.php";
         
             require_once "{$pathToComponents}Common/navbar.php";
         
             require_once "{$pathToComponents}Common/modalSearch.php";

             require_once "{$pathToComponents}Home/hero.php";

             require_once "{$pathToComponents}Home/eventSection.php";


        //If a category has no current events, do not display it
        foreach ($categories as $category) {
            if (isset($eventsByCategory[$category])) {
                require_once "{$pathToComponents}Home/eventCarousel.php";
                }
        }

         require_once "{$pathToComponents}Home/facts.php";

         require_once "{$pathToComponents}Home/testimonialSection.php";

         require_once "{$pathToComponents}Common/footer.php";

         require_once "{$pathToComponents}Common/copyright.php";

         require_once "{$pathToComponents}Common/backToTopButton.php";

         require_once "{$pathToComponents}Common/scripts.php";
    
        ?>


    </body>

</html>
