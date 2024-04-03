<?php
require_once("src/Controllers/includes/configSession.inc.php");
require_once("src/Views/Dashboard/eventAdditionView.php")
?>

<?php include "prefix.php"?>

<!doctype html>
<html lang="en">
<head>
    <?php include 'src/Views/Common/header.php' ?>
</head>
<body>
    <?php include 'src/Views/Common/loadingSpinner.php' ?>

    <?php include 'src/Views/Common/navbar.php' ?>

    <form action="<?="{$prefix}/event_addition"?>" method="post" style = "margin-top: 30vh">
        <?php eventAdditionInput(); ?>
        <div class = "offset-sm-3 col-sm-3 d-grid">
            <button type = "submit" class = "btn btn-primary">Submit</button>
        </div>
        <div class = "col-sm-3 d-grid">
            <a class = "btn btn-outline-primary" href = "<?="{$prefix}/dashboard"?>" role = "button">Cancel</a>
        </div>
    </form>
    <?php checkEventAdditionErrors(); ?>
    <?php checkEventAdditionSuccess(); ?>
    <?php
    if(isset($_GET["eventAddition"])){
        if($_GET["eventAddition"]=="success"){
            header("Location: {$prefix}/dashboard");
        }
    }
    ?>

    <?php include 'src/Views/Common/footer.php' ?>

    <?php include 'src/Views/Common/copyright.php' ?>

    <?php include 'src/Views/Common/backToTopButton.php' ?>

    <?php include 'src/Views/Common/scripts.php' ?>
</body>
</html>