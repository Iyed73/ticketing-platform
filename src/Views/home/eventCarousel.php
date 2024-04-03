<div class="container-fluid vesitable py-5">
    <div class="container py-5">
        <h1 class="mb-0">
            <?= $category; ?>
        </h1>
        <div class="owl-carousel vegetable-carousel justify-content-center">
            <?php
            $categoryCurrentEvents = array_filter($eventsByCategory[$category], function ($event) {
                return strtotime($event->startSellTime) <= time() && time() <= strtotime($event->eventDate);
            });
            ?>
            <?php
            foreach ($categoryCurrentEvents as $event): ?>
                <div class="border border-primary rounded position-relative event-item">
                    <div class="event-img">
                        <img src="<?= $event->imagePath ?>" class="img-fluid w-100 rounded-top" alt="">
                    </div>
                    <div class="text-white bg-primary px-3 py-1 rounded position-absolute" style="top: 10px; right: 10px;">
                        <?= $event->category; ?>
                    </div>
                    <div class="p-4 rounded-bottom">
                        <h4>
                            <?= $event->name; ?>
                        </h4>
                        <p class="text-dark fs-6 fw-bold mb-2">
                            <?= $event->eventDate; ?>
                        </p>
                        <p>
                            <?= $event->shortDescription; ?>
                        </p>
                        <div class="d-flex justify-content-between flex-lg-wrap">
                            <p class="text-dark fs-5 fw-bold mb-0">$
                                <?= $event->ticketPrice / 100 ?>
                            </p>
                            <?php $prefix = $_ENV['prefix']; ?>
                            <a href="<?= "{$prefix}/event?id={$event->id}" ?>"
                                class="btn border border-secondary rounded-pill px-3 text-primary"><i
                                    class="fa fa-eye me-2 text-primary"></i> View Event</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>