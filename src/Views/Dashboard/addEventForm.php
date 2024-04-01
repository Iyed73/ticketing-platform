<?php
require_once("../../Controllers/includes/configSession.inc.php");
require_once("../Dashboard/addEventView.php")
?>
<!doctype html>
<html lang="en">
<head>
    <?php include '../header.php' ?>
</head>
<body>
    <?php include '../loadingSpinner.php' ?>

    <?php include '../navbar.php' ?>

    <form action="../../Controllers/addEventHandler.php" method="post" style = "margin-top: 20vh">
        <?php addEventInput(); ?>
        <button id = "submit" type = "submit" class = "btn btn-primary text-white">Submit</button>
    </form>
    <?php checkAddEventErrors(); ?>
    <?php checkAddEventSuccess(); ?>
    <?php
    if(isset($_GET["addEvent"])){
        if($_GET["addEvent"]=="success"){
            header("Refresh:2; url=loginForm.php");
        }
    }
    ?>

    <?php include '../footer.php' ?>

    <?php include '../copyright.php' ?>

    <?php include '../backToTopButton.php' ?>

    <?php include '../scripts.php' ?>
</body>
</html>
