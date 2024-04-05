<?php

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
    <section class="all">
        <?php

        require_once "{$pathToComponents}Common/loadingSpinner.php";

        require_once "{$pathToComponents}Common/navbar.php";

        require_once "{$pathToComponents}Common/modalSearch.php";

        require_once "{$pathToComponents}Home/hero.php";

        function hasUpcomingEvents($events)
        {
            foreach ($events as $event) {
                if (strtotime($event->startSellTime) > time()) {
                    return true;
                }
            }
            return false;
        }

        function hasCurrentEvents($events)
        {
            foreach ($events as $event) {
                if (strtotime($event->startSellTime) <= time() && strtotime($event->eventDate) >= time()) {
                    return true;
                }
            }
            return false;
        }

        if (hasUpcomingEvents($events)) {
            $upcomingEvents = array_filter($events, function ($event) {
                return strtotime($event->startSellTime) > time();
            });
            require_once "{$pathToComponents}Home/eventSection.php";
        }

        //If a category has no current events, do not display it
        foreach ($categories as $category) {
            if (isset($eventsByCategory[$category]) && hasCurrentEvents($eventsByCategory[$category])) {
                require "{$pathToComponents}Home/eventCarousel.php";
            }
        }

        require_once "{$pathToComponents}Home/facts.php";

        require_once "{$pathToComponents}Home/testimonialSection.php";

        require_once "{$pathToComponents}Common/footer.php";

        require_once "{$pathToComponents}Common/copyright.php";

        require_once "{$pathToComponents}Common/backToTopButton.php";

        require_once "{$pathToComponents}Common/scripts.php";

        ?>

    </section>
</body>

</html>