<div class="container py-5 text-center">
    <div style="margin-top: 20vh;"></div>
    <h1 class="mb-4">Your tickets:</h1>
    <?php foreach ($tickets as $ticket): ?>
        <div class="card ticket-card mb-4">
            <div class="card-body">
                <h5 class="card-title">Ticket ID: <?php echo $ticket['ticket_id']; ?></h5>
                <h6 class="card-subtitle mb-2 text-muted">Ticket for: <?php echo $ticket['first_name'] . ' ' . $ticket['last_name']; ?></h6>
                <p class="card-text">
                    <strong>Event:</strong> <?php echo $ticket['event_name']; ?>,
                    <strong>Venue:</strong> <?php echo $ticket['venue']; ?>,
                    <strong>Date:</strong> <?php echo formatDate($ticket['eventDate']); ?>
                </p>
                <p class="card-text">Purchase Date: <?php echo formatDate($ticket['buy_date']); ?></p>
                <a href="#" class="btn btn-primary text-white">Download Ticket PDF</a>
            </div>
        </div>
    <?php endforeach; ?>
</div>
