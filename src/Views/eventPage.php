<?php 
require_once "src/Controllers/includes/configSession.inc.php";
require_once "src/utils.php";
// Retrieve and unserialize session variables
$event = unserialize($_SESSION["event"]) ?? [];
$pathToComponents = "src/Views/";
$_SESSION["user_id"] = 2;
$_SESSION["role"] = "customer";
$error = $_SESSION["error"] ?? null;
unset($_SESSION["error"]);

// when logged-in user opens the event page, we will check whether he has an ongoing reservation
if (isset($_SESSION["user_id"])) {
    $reservationId = hasOnGoingReservation($event->id, $_SESSION["user_id"]);
} else {
    $hasReservationId = null;
}

include 'prefix.php';
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?= $event->name ?></title>a
        <?php require_once "{$pathToComponents}Common/header.php"; ?>
    </head>

    <body>
        <?php 
        
            require_once "{$pathToComponents}Common/loadingSpinner.php";


            require_once "{$pathToComponents}Common/navbar.php";
            
            
            require_once "{$pathToComponents}Common/modalSearch.php";
            
        ?>

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
                                        <img src="<?= $event->imagePath?>" class="img-fluid rounded" alt="Image">
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <h1 class="fw-bold mb-3"><?= $event->name ?></h1>
                                <h4 class="mb-3 text-secondary">By <?= $event->organizer ?></h4>
                                <p class="fs-5 fw-bold mb-4 text-primary">At <?= $event->venue ?></p>
                                <p class="fs-4 fw-bold mb-4 text-primary"><?= $event->eventDate ?></p>
                                <p class="fs-3 fw-bold mb-3 text-primary">$<?= $event->ticketPrice/100 ?></p>
                                <p class="mb-4"><?= $event->shortDescription ?></p>
                                <?php if ($reservationId != null): ?>
                                    <a href="<?= $prefix ?>/payment?reservation_id=<?= $reservationId ?>" class="btn border border-secondary rounded-pill px-4 py-2 mb-4 text-primary">
                                        <i class="fa fa-credit-card me-2 text-primary"></i> Proceed to Payment
                                    </a>
                                <?php else: ?>
                                    <?php
                                    $canBuyTickets = $event->availableTickets > 0 && strtotime($event->startSellTime) <= time();
                                    ?>
                                    <?php if ($canBuyTickets): ?>
                                        <form id="buyTicketsForm" action="<?= $prefix ?>/reserve" method="post">
                                            <div class="input-group quantity mb-5" style="width: 100px;">
                                                <div class="input-group-btn">
                                                    <button type="button" id="minusBtn" class="btn btn-sm btn-minus rounded-circle bg-light border">
                                                        <i class="fa fa-minus"></i>
                                                    </button>
                                                </div>
                                                <input id="ticketQuantity" name="quantity" type="text" class="form-control form-control-sm text-center border-0" value="1">
                                                <div class="input-group-btn">
                                                    <button type="button" id="plusBtn" class="btn btn-sm btn-plus rounded-circle bg-light border">
                                                        <i class="fa fa-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <p class="fs-4 fw-bold mb-3 text-danger">Remaining Tickets: <?= $event->availableTickets ?></p>
                                            <input type="hidden" name="event_id" value="<?= $event->id ?>">
                                            <button type="submit" class="btn border border-secondary rounded-pill px-4 py-2 mb-4 text-primary">
                                                <i class="fa fa-shopping-bag me-2 text-primary"></i> Buy Tickets
                                            </button>
                                        </form>
                                    <?php else: ?>
                                        <p class="text-primary fs-5 fw-bold">Stay Tuned for Ticket Sales</p>
                                    <?php endif; ?>
                                <?php endif; ?>
                                <?php if ($error): ?>
                                <div id="error-message" class="text-danger mt-2"><?= $error ?></div>
                                <?php endif; ?>
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
                                            <?= $event->longDescription ?>
                                        </p>
                                            
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <?php require_once "{$pathToComponents}EventPage/eventPageCarousel.php"; ?>
            </div>
        </div>
    

        <?php 
            require_once "{$pathToComponents}Common/footer.php";
        
            require_once "{$pathToComponents}Common/copyright.php"; 

            require_once "{$pathToComponents}Common/backToTopButton.php";

            require_once "{$pathToComponents}Common/scripts.php";
        ?>
    </body>

</html>