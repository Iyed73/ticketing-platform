<?php
require_once "src/Controllers/includes/configSession.inc.php";

// Retrieve and unserialize session variables
$searchedEvents = unserialize($_SESSION["searchedEvents"]) ?? [];
$categories = unserialize($_SESSION["categories"]) ?? [];
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

    require_once "{$pathToComponents}Search/searchEventSection.php";

    require_once "{$pathToComponents}Common/footer.php";

    require_once "{$pathToComponents}Common/copyright.php";

    require_once "{$pathToComponents}Common/backToTopButton.php";

    require_once "{$pathToComponents}Common/scripts.php";

    ?>


</body>

</html>