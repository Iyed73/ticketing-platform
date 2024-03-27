<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <title>Tickety - Event Booking Platform</title>
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <meta content="" name="keywords">
        <meta content="" name="description">

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Raleway:wght@600;800&display=swap" rel="stylesheet"> 

        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

        <link href="lib/lightbox/css/lightbox.min.css" rel="stylesheet">
        <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">


        <link href="Static/CSS/bootstrap.min.css" rel="stylesheet">

        <link href="Static/CSS/styles.css" rel="stylesheet">
    </head>

    <body>
        <!-- Loading Animation -->
        <div id="spinner" class="show w-100 vh-100 bg-white position-fixed translate-middle top-50 start-50  d-flex align-items-center justify-content-center">
            <div class="spinner-grow text-primary" role="status"></div>
        </div>


        <?php include 'src/Views/home/navbar.php' ?>


        <?php include 'src/Views/home/modalSearch.php' ?>


        <?php include 'src/Views/home/hero.php' ?>

        <?php
        // some dummy data
        $categories = ["Category 1", "Category 2", "Category 3"];
        $events = [
            [
                "name" => "Event 1",
                "category" => "Category 1",
                "description" => "Description of Event 1",
                "price" => 10.99,
                "startSellTime" => "2024-03-30 09:00:00",
                "endSellTime" => "2024-03-30 18:00:00",
                "eventDate" => "2024-04-01",
                "image" => "image1.jpg"
            ],
            [
                "name" => "Event 2",
                "category" => "Category 2",
                "description" => "Description of Event 2",
                "price" => 15.99,
                "startSellTime" => "2024-03-31 09:00:00",
                "endSellTime" => "2024-03-31 18:00:00",
                "eventDate" => "2024-04-02",
                "image" => "image2.jpg"
            ],
            [
                "name" => "Event 3",
                "category" => "Category 3",
                "description" => "Description of Event 3",
                "price" => 20.99,
                "startSellTime" => "2024-04-01 09:00:00",
                "endSellTime" => "2024-04-01 18:00:00",
                "eventDate" => "2024-04-03",
                "image" => "image3.jpg"
            ],
            [
                "name" => "Event 4",
                "category" => "Category 1",
                "description" => "Description of Event 4",
                "price" => 25.99,
                "startSellTime" => "2024-03-25 10:00:00",
                "endSellTime" => "2024-03-30 18:00:00",
                "eventDate" => "2024-03-27",
                "image" => "image4.jpg"
            ],
            [
                "name" => "Event 5",
                "category" => "Category 3",
                "description" => "Description of Event 5",
                "price" => 30.99,
                "startSellTime" => "2024-03-20 09:00:00",
                "endSellTime" => "2024-03-30 18:00:00",
                "eventDate" => "2024-03-22",
                "image" => "image5.jpg"
            ],
            [
                "name" => "Event 6",
                "category" => "Category 3",
                "description" => "Description of Event 5",
                "price" => 30.99,
                "startSellTime" => "2024-03-20 09:00:00",
                "endSellTime" => "2024-03-30 18:00:00",
                "eventDate" => "2024-03-22",
                "image" => "image5.jpg"
            ]
        ];
        ?>


        <?php

        include 'src/Views/home/eventSection.php';
        ?>
        

        <?php //include 'src/Views/home/featuresSection.php' ?>


        <?php

        foreach ($categories as $category) {
            include 'src/Views/home/eventCarousel.php';
        }
        ?>



        <?php //include 'src/Views/home/bannerSection.php' ?>
        

        <?php //include 'src/Views/home/bestSellerSection.php' ?>
        

        <?php //include 'src/Views/home/factsSection.php' ?>


        <?php include 'src/Views/home/anotherFeatureSection.php' ?>


        <?php include 'src/Views/home/testimonialSection.php' ?>


        <?php include 'src/Views/home/footer.php' ?>
        
        
        <?php include 'src/Views/home/copyright.php' ?>



    <!-- Back To Top Button -->
    <a href="#" class="btn btn-primary border-3 border-primary rounded-circle back-to-top"><i class="fa fa-arrow-up"></i></a>   

        
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/lightbox/js/lightbox.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>

    <script src="Static/JS/main.js"></script>
    </body>

</html>
