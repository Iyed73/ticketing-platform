<?php include "prefix.php"; ?>

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
            <th scope="col">Actions</th>

        </tr>
        </thead>
        <tbody>
        <?php foreach ($allEvents as $e): ?>
            <tr>
                <td><?php echo $e->id; ?></td>
                <td><?php echo $e->name; ?></td>
                <td><?php echo $e->venue; ?></td>
                <td><?php echo $e->category; ?></td>
                <td><?php echo $e->eventDate; ?></td>
                <td><?php echo $e->shortDescription; ?></td>
                <td><?php echo $e->longDescription; ?></td>
                <td><?php echo $e->organizer; ?></td>
                <td><?php echo $e->startSellTime; ?></td>
                <td><?php echo $e->endSellTime; ?></td>
                <td><?php echo $e->totalTickets; ?></td>
                <td><?php echo $e->availableTickets; ?></td>
                <td><?php echo $e->ticketPrice; ?></td>
                <td>
                    <div class="btn-group" role="group" aria-label="Edit and Delete buttons">
                        <button type="button" class="btn btn-primary text-white">Edit</button>
                        <button class="btn btn-danger">Delete</button>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <nav aria-label="page_nav" class="d-flex justify-content-center">
        <ul class="pagination">
            <?php if ($currentPage > 1): ?>
                <li class="page-item">
                    <a class="page-link" href="?page=<?php echo $currentPage - 1; ?>">Previous</a>
                </li>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <li class="page-item <?php echo ($currentPage == $i) ? 'active' : ''; ?>">
                    <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                </li>
            <?php endfor; ?>

            <?php if ($currentPage < $totalPages): ?>
                <li class="page-item">
                    <a class="page-link" href="?page=<?php echo $currentPage + 1; ?>">Next</a>
                </li>
            <?php endif; ?>
        </ul>
    </nav>


</div>
