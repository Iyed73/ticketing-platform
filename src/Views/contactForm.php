<?php
$pathToComponents = "src/Views/";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Contact us</title>
    <?php require_once "{$pathToComponents}Common/header.php" ?>
</head>

<body>
    <section class="all">

        <?php

        require_once "{$pathToComponents}Common/navbar.php";

        require_once "{$pathToComponents}Common/modalSearch.php";
        
        
        require_once "{$pathToComponents}contactPage\contactFormView.php";

        
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