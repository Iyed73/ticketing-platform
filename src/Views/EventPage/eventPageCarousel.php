<h1 class="fw-bold mb-5">Similar Events</h1>
<div class="owl-carousel vegetable-carousel justify-content-center">
    <?php
     foreach ($currentCategoryEvents as $e): ?>
            <div class="border border-primary rounded position-relative event-item">
                <div class="event-img">
                    <img src="<?= $e->imagePath ?>" class="img-fluid w-100 rounded-top" alt="">
                </div>
                <div class="text-white bg-primary px-3 py-1 rounded position-absolute" style="top: 10px; right: 10px;"><?php echo $event->category; ?> </div>
                <div class="p-4 rounded-bottom">
                    <h4><?= $e->name; ?></h4>
                    <p class="text-dark fs-6 fw-bold mb-2"> <?= $e->eventDate; ?></p>
                    <p><?= $e->shortDescription; ?></p>
                    <div class="d-flex justify-content-between flex-lg-wrap">
                        <p class="text-dark fs-5 fw-bold mb-0"><?=  $currencySymbol . $e->ticketPrice/100; ?></p>
                        <?php 
                            $prefix = $_ENV['prefix'];
                        ?>
                        <a href="<?= "{$prefix}/event?id={$e->id}" ?>" class="btn border border-secondary rounded-pill px-3 text-primary"><i class="fa fa-eye me-2 text-primary"></i> View Event</a>
                    </div>
                </div>
            </div>
    <?php endforeach; ?>

</div>