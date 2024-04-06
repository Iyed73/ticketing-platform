<?php
$reservation_id = $_GET["reservation_id"] ?? '';

$error = $_SESSION["error"] ?? null;
unset($_SESSION["error"]);
?>
<div class="container py-5">
    <div style="margin-top: 20vh;"></div>
    <?php if ($error): ?>
        <div class="alert alert-danger text-center mb-5" role="alert">
            <?php echo $error; ?>
        </div>
    <?php endif; ?>
    <div class="text-center mb-3">
        <h3>Total Price: $<?php echo number_format($totalPrice, 2); ?></h3>
        <h3 id="countdown"></h3>
    </div>
    <form method="post" action="cancel"  class="text-center mb-5">
        <input type="hidden" name="reservation_id" value="<?php echo $reservation_id; ?>">
        <button type="submit" name="cancel" class="btn btn-secondary mb-3 text-white">Cancel</button>
    </form>
    <h2>Enter Client Information</h2>
    <form method="post" action="payment">
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
<script>
    
    let expirationTime = new Date("<?php echo $expiration; ?>").getTime();
    let countdown = document.querySelector('#countdown');

    // Update the countdown every second
    let countdownInterval = setInterval(function() {
        let now = new Date().getTime();
        let remainingTime = expirationTime - now;

        let hours = Math.floor((remainingTime % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        let minutes = Math.floor((remainingTime % (1000 * 60 * 60)) / (1000 * 60));
        let seconds = Math.floor((remainingTime % (1000 * 60)) / 1000);
        
        let text = "Expires After: " + hours + "h " + minutes + "m " + seconds + "s ";

        countdown.innerHTML = text;

        if (remainingTime < 0) {
            clearInterval(countdownInterval);
            countdown.innerHTML = "Reservation expired!";
        }
    }, 1000);
</script>
