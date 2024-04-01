<h1 class="fw-bold mb-5">Similar Events</h1>
<div class="owl-carousel vegetable-carousel justify-content-center">
    <?php

    require_once "../Controllers/includes/configSession.inc.php";

    // Retrieve and unserialize session variables
    $currentCategoryEvents = unserialize($_SESSION["currentCategoryEvents"]) ?? [];
    

    foreach ($currentCategoryEvents as $event): ?>
        <?php
        // Check if the event category matches the current category and the event is within the selling time
        if(strtotime($event->startSellTime) <= time() && time() <= strtotime($event->endSellTime)):
            ?>
            <div class="border border-primary rounded position-relative event-item">
                <div class="event-img">
                    <img src="<?= $event->imagePath ?>" class="img-fluid w-100 rounded-top" alt="">
                </div>
                <div class="text-white bg-primary px-3 py-1 rounded position-absolute" style="top: 10px; right: 10px;"><?php echo $event->category; ?> </div>
                <div class="p-4 rounded-bottom">
                    <h4><?php echo $event->name; ?></h4>
                    <p class="text-dark fs-6 fw-bold mb-2"> <?= $event->eventDate; ?></p>
                    <p><?php echo $event->shortDescription; ?></p>
                    <div class="d-flex justify-content-between flex-lg-wrap">
                        <p class="text-dark fs-5 fw-bold mb-0">$<?= $event->ticketPrice/100; ?></p>
                        <?php 
                            require_once 'prefix.php';
                        ?>
                        <a href="<?= "{$prefix}/event?id={$event->id}" ?>" class="btn border border-secondary rounded-pill px-3 text-primary"><i class="fa fa-eye me-2 text-primary"></i> View Event</a>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>

</div>