<!DOCTYPE html>
<html lang="en">

    <?php 
        //dummy event data

        $event = [
            "name"=> "Concert",
            "category"=> "Music",
            "ticketPrice" => 337,
            "shortDescription" => "Experience the electrifying energy of live music at our concert! Immerse in the rhythm, lights, and the unforgettable atmosphere.",
            "longDescription"=> "Immerse yourself in the electrifying atmosphere of our live concert. Feel the rhythm pulsate through the crowd as the stage lights dance. Witness the raw energy of the performers, their music resonating in perfect harmony with the audience’s excitement. It’s not just a concert, it’s an unforgettable experience of a lifetime.",
            "image"=> "Static/Images/event-1.jpg",
            ]

    ?>


    <head>
        <title><?php echo $event['name'] ?> </title>
        <?php include 'src/Views/header.php' ?>
    </head>

    <body>
        <?php include 'src/Views/loadingSpinner.php' ?>


        <?php include 'src/Views/navbar.php' ?>


        <?php include 'src/Views/modalSearch.php' ?>

        <!-- needs a workaround :( -->
        <br />
        <br />
        <br />

        <div class="container-fluid py-5 mt-5">
            <div class="container py-5">
                <div class="row g-4 mb-5">
                    <div class="col-lg-8 col-xl-9">
                        <div class="row g-4">
                            <div class="col-lg-6">
                                <div class="border rounded">
                                    <a href="#">
                                        <img src="<?php echo $event["image"] ?>" class="img-fluid rounded" alt="Image">
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <h4 class="fw-bold mb-3"><?php echo $event['name'] ?></h4>
                                <p class="mb-3"><?php echo $event['category'] ?></p>
                                <h5 class="fw-bold mb-3"><?php echo $event['ticketPrice']/100 ?> $</h5>
                                <p class="mb-4"><?php echo $event['shortDescription'] ?></p>
                                <div class="input-group quantity mb-5" style="width: 100px;">
                                    <div class="input-group-btn">
                                        <button class="btn btn-sm btn-minus rounded-circle bg-light border" >
                                            <i class="fa fa-minus"></i>
                                        </button>
                                    </div>
                                    <input type="text" class="form-control form-control-sm text-center border-0" value="1">
                                    <div class="input-group-btn">
                                        <button class="btn btn-sm btn-plus rounded-circle bg-light border">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                                <a href="#" class="btn border border-secondary rounded-pill px-4 py-2 mb-4 text-primary"><i class="fa fa-shopping-bag me-2 text-primary"></i> Buy Tickets </a>
                            </div>
                            <div class="col-lg-12">
                                <nav>
                                    <div class="nav nav-tabs mb-3">
                                        <button class="nav-link active border-white border-bottom-0" type="button" role="tab"
                                            id="nav-about-tab" data-bs-toggle="tab" data-bs-target="#nav-about"
                                            aria-controls="nav-about" aria-selected="true">Description</button>
                                    </div>
                                </nav>
                                <div class="tab-content mb-5">
                                    <div class="tab-pane active" id="nav-about" role="tabpanel" aria-labelledby="nav-about-tab">
                                        <p>
                                            <?php echo $event["longDescription"] ?>
                                        </p>
                                            
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <?php include 'src/Views/EventPage/eventPageCarousel.php' ?>
            </div>
        </div>
    

        <?php include 'src/Views/footer.php' ?>
        
        
        <?php include 'src/Views/copyright.php' ?>
        

        <?php include 'src/Views/backToTopButton.php' ?>
        

        <?php include 'src/Views/scripts.php' ?>
    </body>

</html>