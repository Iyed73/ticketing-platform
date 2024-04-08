<?php

// Retrieve and unserialize session variables
$event = unserialize($_SESSION["event"]) ?? [];
$currentCategoryEvents = unserialize($_SESSION["currentCategoryEvents"]) ?? [];
$pathToComponents = "src/Views/";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>
        <?= $event->name ?>
    </title>
    <?php require_once "{$pathToComponents}Common/header.php"; ?>
</head>

<body>
    <section class="all">
        <?php

        require_once "{$pathToComponents}Common/loadingSpinner.php";


        require_once "{$pathToComponents}Common/navbar.php";


        require_once "{$pathToComponents}Common/modalSearch.php";

        ?>


        <div class="container-fluid py-5 mt-5">
            <div class="container py-5">
                <div class="row g-4 mb-5">
                    <div class="col-lg-8 col-xl-9">
                        <div class="row g-4">
                            <div class="col-lg-6">
                                <div class="border rounded">
                                    <a href="#">
                                        <img src="<?= $event->imagePath ?>" class="img-fluid rounded" alt="Image">
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <h1 class="fw-bold mb-3">
                                    <?= $event->name ?>
                                </h1>
                                <h4 class="mb-3 text-secondary">By
                                    <?= $event->organizer ?>
                                </h4>
                                <p class="fs-5 fw-bold mb-4 text-primary">At
                                    <?= $event->venue ?>
                                </p>
                                <p class="fs-4 fw-bold mb-4 text-primary">
                                    <?= $event->eventDate ?>
                                </p>
                                <p class="fs-3 fw-bold mb-3 text-primary">
                                    <?=  $currencySymbol . $event->ticketPrice / 100 ?>
                                </p>
                                <p class="mb-4">
                                    <?= $event->shortDescription ?>
                                </p>
                                <div class="input-group quantity mb-5" style="width: 100px;">
                                    <div class="input-group-btn">
                                        <button class="btn btn-sm btn-minus rounded-circle bg-light border">
                                            <i class="fa fa-minus"></i>
                                        </button>
                                    </div>
                                    <input type="text" class="form-control form-control-sm text-center border-0"
                                        value="1">
                                    <div class="input-group-btn">
                                        <button class="btn btn-sm btn-plus rounded-circle bg-light border">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                                <p class="fs-4 fw-bold mb-3 text-danger">Remaining Tickets:
                                    <?= $event->availableTickets ?>
                                </p>
                                <a href="#"
                                    class="btn border border-secondary rounded-pill px-4 py-2 mb-4 text-primary"><i
                                        class="fa fa-shopping-bag me-2 text-primary"></i> Buy Tickets </a>
                            </div>
                            <div class="col-lg-12">
                                <nav>
                                    <div class="nav nav-tabs mb-3">
                                        <button class="nav-link active border-white border-bottom-0" type="button"
                                            role="tab" id="nav-about-tab" data-bs-toggle="tab"
                                            data-bs-target="#nav-about" aria-controls="nav-about"
                                            aria-selected="true">Description</button>
                                    </div>
                                </nav>
                                <div class="tab-content mb-5">
                                    <div class="tab-pane active" id="nav-about" role="tabpanel"
                                        aria-labelledby="nav-about-tab">
                                        <p>
                                            <?= $event->longDescription ?>
                                        </p>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



            <?php
            if (count($currentCategoryEvents) > 0) {
                require_once "{$pathToComponents}EventPage/eventPageCarousel.php";
            }
            ?>
        </div>


        <?php
        require_once "{$pathToComponents}Common/footer.php";

        require_once "{$pathToComponents}Common/copyright.php";

        require_once "{$pathToComponents}Common/backToTopButton.php";

        require_once "{$pathToComponents}Common/scripts.php";
        ?>
    </section>
</body>

</html>