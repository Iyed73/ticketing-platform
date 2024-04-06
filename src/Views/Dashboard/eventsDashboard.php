<?php include "prefix.php"; ?>

<div class="container-fluid py-5" style="margin-top: 20vh">
    <h2>All Events</h2>
    <a class="btn btn-primary text-white" href="<?= "{$prefix}/event_addition" ?>" role="button">Add Event</a>
    <br>
    <div class="row d-flex justify-content-center">
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
                    <td>
                        <a href ="#" data-toggle="tooltip" data-title="<?php echo $e->longDescription; ?>">See Details</a>
                    </td>
                    <td><?php echo $e->organizer; ?></td>
                    <td><?php echo $e->startSellTime; ?></td>
                    <td><?php echo $e->endSellTime; ?></td>
                    <td><?php echo $e->totalTickets; ?></td>
                    <td><?php echo $e->availableTickets; ?></td>
                    <td><?php echo $e->ticketPrice; ?></td>
                    <td>
                        <div class="btn-group" role="group" aria-label="Edit and Delete buttons">
                            <a class = "btn btn-primary text-white" href = "<?="{$prefix}/event_update?id={$e->id}"?>" role="button">Edit</a>
                            <a href = "<?="{$prefix}/event_delete?id={$e->id}"?>" class="btn btn-danger" onclick ="return confirm('Are you sure to delete this event?')">Delete</a>
                            <a href="<?= "{$prefix}/event?id={$e->id}" ?>" class="btn btn-primary">
                                <i class="fa fa-eye me-2 text-white"></i>
                            </a>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>

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


<script>
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip({
            trigger: 'hover'
        });
    });
</script>

<style>
    [data-title]:hover:after {
        opacity: 1;
        transition: all 0.1s ease 0.5s;
        visibility: visible;
    }
    [data-title]:after {
        content: attr(data-title);
        background-color: #FFFFFF;
        color: #111;
        font-size: 80%;
        position: absolute;
        padding: 5px;
        border-radius: 5px;
        bottom: -1.6em;
        left: 100%;
        white-space: nowrap;
        box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2);
        opacity: 0;
        z-index: 99999;
        visibility: hidden;
    }
    [data-title] {
        position: relative;
    }
</style>

