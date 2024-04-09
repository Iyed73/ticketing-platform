<?php $prefix = $_ENV['prefix']; ?>

<div class="container-fluid py-5" style="margin-top: 20vh">
    <h2>All Tickets</h2>
    <br>
    <div class="row d-flex justify-content-center">
        <table class="table table-striped">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Purchase Date</th>
                <th scope="col">Price</th>
                <th scope="col">Buyer Firstname</th>
                <th scope="col">Buyer Lastname</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($allTickets as $ticket): ?>
                <tr>
                    <td><?php echo $ticket->ticket_id; ?></td>
                    <?php
                    $ticketInfo = $ticketModel->getTicketInfoById($ticket->ticket_id);
                    if ($ticketInfo !== null) {
                        ?>
                        <td><?php echo $ticketInfo->buy_date; ?></td>
                        <td><?php echo $ticketInfo->price; ?></td>
                        <td><?php echo $ticketInfo->buyer_firstname; ?></td>
                        <td><?php echo $ticketInfo->buyer_lastname; ?></td>

                        <?php
                    } else {
                        ?>
                        <td colspan="3">Ticket info not found</td>
                        <?php
                    }
                    ?>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <nav aria-label="page_nav" class="d-flex justify-content-center">
        <ul class="pagination d-inline-flex justify-content-between">
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
