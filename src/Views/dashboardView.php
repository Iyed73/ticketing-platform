<?php
$pathToComponents = "src/Views/";

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once "{$pathToComponents}Common/header.php"; ?>
</head>

<body>

<?php include "{$pathToComponents}Common/loadingSpinner.php" ?>

<?php include "{$pathToComponents}Common/navbar.php" ?>

<?php include "{$pathToComponents}Common/modalSearch.php" ?>

<?php include "dashboardElements.php" ?>


<?php include "{$pathToComponents}Common/footer.php" ?>


<?php include "{$pathToComponents}Common/copyright.php" ?>


<?php include "{$pathToComponents}Common/scripts.php"?>
</body>

</html>
