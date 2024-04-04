<?php require "prefix.php"; ?>

<div class="container-fluid py-5" style="margin-top: 20vh">
    <h2>All Events</h2>
    <a class="btn btn-primary text-white" href="<?= "{$prefix}/event_addition" ?>" role="button">Add Event</a>
    <br>
        <table class="table table-striped">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Venue</th>
                <th scope="col">Category</th>
                <th scope="col">Date</th>
                <th scope="col">Short Description</th>
                <th scope="col">Long Description</th>
                <th scope="col">Organizer</th>
                <th scope="col">Start Sell Time</th>
                <th scope="col">End Sell Time</th>
                <th scope="col">Total Tickets</th>
                <th scope="col">Available Tickets</th>
                <th scope="col">Ticket Price</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($events as $event): ?>
                <tr>
                    <td><?php echo $event->id; ?></td>
                    <td><?php echo $event->name; ?></td>
                    <td><?php echo $event->venue; ?></td>
                    <td><?php echo $event->category; ?></td>
                    <td><?php echo $event->eventDate; ?></td>
                    <td><?php echo $event->shortDescription; ?></td>
                    <td><?php echo $event->longDescription; ?></td>
                    <td><?php echo $event->organizer; ?></td>
                    <td><?php echo $event->startSellTime; ?></td>
                    <td><?php echo $event->endSellTime; ?></td>
                    <td><?php echo $event->totalTickets; ?></td>
                    <td><?php echo $event->availableTickets; ?></td>
                    <td><?php echo $event->ticketPrice; ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
</div>
