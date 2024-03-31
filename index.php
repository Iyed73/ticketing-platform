

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Tickety - Event Booking Platform</title>
    <?php include 'src/Views/header.php' ?>
</head>

<body>
    <section class="all">

        <?php include 'src/Views/loadingSpinner.php' ?>
        
        
        <?php include 'src/Views/navbar.php' ?>
        
        
        <?php include 'src/Views/modalSearch.php' ?>
        
        
        <?php include 'src/Views/home/hero.php' ?>
        
        
        <?php include 'src/Views/eventArray.php' ?>
        
        <?php

        include 'src/Views/home/eventSection.php';
        ?>
        
        
        <?php //include 'src/Views/home/featuresSection.php'   ?>
        
        
        <?php
        //If a category has no current events, do not display it
        foreach ($categories as $category) {
            if (isset($eventsByCategory[$category])) {
                include 'src/Views/home/eventCarousel.php';
            }
        }
        ?>
        
        
        
        <?php //include 'src/Views/home/bannerSection.php'   ?>
        
        
        <?php //include 'src/Views/home/bestSellerSection.php'   ?>
        
        
        <?php //include 'src/Views/home/factsSection.php'   ?>
        
        
        <?php include 'src/Views/home/anotherFeatureSection.php' ?>
        
        
        <?php include 'src/Views/home/testimonialSection.php' ?>
        
        
        <?php include 'src/Views/footer.php' ?>
        
        
        <?php include 'src/Views/copyright.php' ?>
        
        
        <?php include 'src/Views/backToTopButton.php' ?>
        
        
        <?php include 'src/Views/scripts.php' ?>

    </section>
        
</body>

</html>