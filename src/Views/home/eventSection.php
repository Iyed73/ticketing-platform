<div class="container-fluid fruite py-5">
        <div class="container py-5">
            <div class="tab-class text-center">
                <div class="row g-4">
                    <div class="col-lg-4 text-start">
                        <h1>Upcoming Events</h1>
                    </div>
                    <div class="col-lg-8 text-end">
                        <ul class="nav nav-pills d-inline-flex text-center mb-5">
                            <li class="nav-item">
                                <a class="d-flex m-2 py-2 bg-light rounded-pill active" data-bs-toggle="pill" href="#tab-1">
                                    <span class="text-dark" style="width: 130px;">All Events</span>
                                </a>
                            </li>
                            <?php foreach ($categories as $index => $category): ?>
                                <li class="nav-item">
                                    <!--  -->
                                    <a class="d-flex m-2 py-2 bg-light rounded-pill" data-bs-toggle="pill" href="#tab-<?php
                                    // index + 2 in order to make tab starting from 2 -> number of categories + 1 since tab-1 reserved for all events
                                    echo $index + 2; ?>">
                                        <span class="text-dark" style="width: 130px;"><?php echo $category; ?></span>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
                <div class="tab-content">
                    <div id="tab-1" class="tab-pane fade show p-0 active">
                        <div class="row g-4">
                            <div class="col-lg-12">
                                <div class="row g-4">
                                    <?php foreach ($events as $event): ?>
                                        <?php
                                        // Check if event start selling tickets time is less than current time
                                        if (strtotime($event['startSellTime']) > time()): ?>
                                            <div class="col-md-6 col-lg-4 col-xl-3">
                                                <div class="rounded position-relative event-item">
                                                    <div class="event-img">
                                                        <img src="<?= $event['image'] ?>" class="img-fluid w-100 rounded-top" alt="">
                                                    </div>
                                                    <div class="text-white bg-secondary px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;"><?= $event['category'] ?></div>
                                                    <div class="p-4 border border-secondary border-top-0 rounded-bottom">
                                                        <h4><?= $event['name'] ?></h4>
                                                        <p><?= $event['description'] ?></p>
                                                        <div class="d-flex justify-content-between flex-lg-wrap">
                                                            <p class="text-dark fs-5 fw-bold mb-0">$<?= $event['price'] ?></p>
                                                            <a href="<?php // url_for('eventPage', ['id' => $event['id']]) ?>" class="btn border border-secondary rounded-pill px-3 text-primary"><i class="fa fa-eye me-2 text-primary"></i> View Event</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    <?php endforeach; ?>

                                </div>
                            </div>
                        </div>
                    </div>
                    <?php foreach ($categories as $index => $category): ?>
                        <div id="tab-<?php echo $index + 2; ?>" class="tab-pane fade show p-0">
                            <div class="row g-4">
                                <div class="col-lg-12">
                                    <div class="row g-4">
                                        <?php foreach ($events as $event): ?>
                                            <?php if (strtotime($event['startSellTime']) > time() && ($event['category'] == $category)): ?>
                                                <div class="col-md-6 col-lg-4 col-xl-3">
                                                    <div class="rounded position-relative event-item">
                                                        <div class="event-img">
                                                            <img src="<?= $event['image'] ?>" class="img-fluid w-100 rounded-top" alt="">
                                                        </div>
                                                        <div class="text-white bg-secondary px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;"><?= $category ?></div>
                                                        <div class="p-4 border border-secondary border-top-0 rounded-bottom">
                                                            <h4><?= $event['name'] ?></h4>
                                                            <p><?= $event['description'] ?></p>
                                                            <div class="d-flex justify-content-between flex-lg-wrap">
                                                                <p class="text-dark fs-5 fw-bold mb-0">$<?= $event['price'] ?></p>
                                                                <a href="<?php // url_for('eventPage', ['id' => $event['id']]) ?>" class="btn border border-secondary rounded-pill px-3 text-primary"><i class="fa fa-eye me-2 text-primary"></i> View Event</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
</div>