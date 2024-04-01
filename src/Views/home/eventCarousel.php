<div class="container-fluid vesitable py-5">
    <div class="container py-5">
        <h1 class="mb-0"><?php echo $category; ?></h1>
        <div class="owl-carousel vegetable-carousel justify-content-center">
            <?php
            $hasEvents = false;
            foreach ($eventsByCategory[$category] as $event): ?>
                <?php
                // Check if the event category matches the current category and the event is within the selling time
                if(strtotime($event->startSellTime) <= time() && time() <= strtotime($event->endSellTime)):
                    $hasEvents = true;
                    ?>
                    <div class="border border-primary rounded position-relative event-item">
                        <div class="event-img">
                            <img src="<?= $event->imagePath ?>" class="img-fluid w-100 rounded-top" alt="">
                        </div>
                        <div class="text-white bg-primary px-3 py-1 rounded position-absolute" style="top: 10px; right: 10px;"><?php echo $event->category; ?></div>
                        <div class="p-4 rounded-bottom">
                            <h4><?php echo $event->name; ?></h4>
                            <p class="text-dark fs-6 fw-bold mb-2"> <?= $event->eventDate; ?></p>
                            <p><?php echo $event->shortDescription; ?></p>
                            <div class="d-flex justify-content-between flex-lg-wrap">
                                <p class="text-dark fs-5 fw-bold mb-0">$<?php echo $event->ticketPrice; ?> </p>
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
        <?php if (!$hasEvents): ?>
            <div class="mt-4 text-center">No events in this category for now.</div>
        <?php endif; ?>
    </div>
</div>
