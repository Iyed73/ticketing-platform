
<?php

$pathToComponents = "src/Views/";
function formatDate($date) {
    return date('F j, Y', strtotime($date));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once "{$pathToComponents}Common/header.php"; ?>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Tickets</title>
    <style>
        .ticket-card {
            width: 90%;
            max-width: 600px;
            margin: 0 auto;
            margin-bottom: 20px;
            border: 2px solid #000;
            border-radius: 10px;
            margin-bottom: 20px;
            padding: 15px;
        }
    </style>
</head>
<body>


<?php include "{$pathToComponents}Common/navbar.php" ?>

<?php include "{$pathToComponents}Common/modalSearch.php" ?>

<?php include "ticketsContainer.php" ?>


<?php include "{$pathToComponents}Common/footer.php" ?>


<?php include "{$pathToComponents}Common/copyright.php" ?>


<?php include "{$pathToComponents}Common/scripts.php"?>

</body>
</html>