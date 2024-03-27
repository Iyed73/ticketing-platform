<h1 class="fw-bold mb-0">Similar Events</h1>
<div class="owl-carousel vegetable-carousel justify-content-center">
    <?php
    include 'src/Views/eventArray.php';
    $currentCategory = 'Category 1';
    $hasEvents = false;
    foreach ($eventsByCategory[$currentCategory] as $event): ?>
        <?php
        // Check if the event category matches the current category and the event is within the selling time
        if(strtotime($event['startSellTime']) <= time() && time() <= strtotime($event['endSellTime'])):
            $hasEvents = true;
            ?>
            <div class="border border-primary rounded position-relative event-item">
                <div class="event-img">
                    <img src="<?= $event['image'] ?>" class="img-fluid w-100 rounded-top" alt="">
                </div>
                <div class="text-white bg-primary px-3 py-1 rounded position-absolute" style="top: 10px; right: 10px;"><?php echo $event['category']; ?></div>
                <div class="p-4 rounded-bottom">
                    <h4><?php echo $event['name']; ?></h4>
                    <p><?php echo $event['description']; ?></p>
                    <div class="d-flex justify-content-between flex-lg-wrap">
                        <p class="text-dark fs-5 fw-bold mb-0">$<?php echo $event['price']; ?> </p>
                        <a href="<?php // url_for('eventPage', ['id' => $event['id']]) ?>" class="btn border border-secondary rounded-pill px-3 text-primary"><i class="fa fa-eye me-2 text-primary"></i> View Event</a>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>

</div>
<?php if (!$hasEvents): ?>
    <div class="mt-4 text-center">No events in this category for now.</div>

<?php endif; ?>
