<div class="container py-5">
    <div style="margin-top: 20vh;"></div>
    <form method="post" action="../Controllers/CancelReservationController.php" class="text-center mb-5">
        <button type="submit" name="cancel" class="btn btn-secondary mb-3 text-white">Cancel</button>
    </form>
    <h2>Enter Client Information</h2>
    <form method="post" action="../Controllers/PaymentController.php">
        <?php
        $quantity = $_GET["quantity"] ?? 1;
        $reservation_id = $_GET["reservation_id"] ?? '';
        ?>
        <input type="hidden" name="reservation_id" value="<?php echo $reservation_id; ?>">
        <?php
        for ($i = 1; $i <= $quantity; $i++) {
            ?>
            <div style="margin-bottom: 12vh;">
                <h4>Client <?php echo $i; ?></h4>
                <div class="row mb-3">
                    <div class="col-sm-4">
                        <input type="text" class="form-control" name="first_names[]" placeholder="First Name" required>
                    </div>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" name="last_names[]" placeholder="Last Name" required>
                    </div>
                    <div class="col-sm-4">
                        <input type="email" class="form-control" name="emails[]" placeholder="Email" required>
                    </div>
                </div>
            </div>
        <?php } ?>

        <hr>

        <h2>Enter Credit Card Information</h2>
        <div class="row mb-3">
            <div class="col-sm-6">
                <label for="credit_card">Credit Card Number</label>
                <input type="text" class="form-control" name="credit_card" id="credit_card" placeholder="Enter Credit Card Number" required>
            </div>
            <div class="col-sm-3">
                <label for="expiration_date">Expiration Date</label>
                <input type="text" class="form-control" name="expiration_date" id="expiration_date" placeholder="MM/YYYY" required>
            </div>
            <div class="col-sm-3">
                <label for="cvv">CVV</label>
                <input type="text" class="form-control" name="cvv" id="cvv" placeholder="CVV" required>
            </div>
        </div>

        <button type="submit" class="btn btn-primary text-white">Submit Payment</button>
    </form>
</div>

