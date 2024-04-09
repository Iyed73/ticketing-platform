<div class="container-fluid bg-dark text-white-50 footer pt-5 mt-5">
    <div class="container py-5">
        <div class="pb-4 mb-4" style="border-bottom: 1px solid rgba(247, 92, 125, 0.5) ;">
            <div class="row g-4">
                <div class="col-lg-3">
                    <?php $prefix = $_ENV['prefix']; ?>
                    <a href=<?= "{$prefix}/" ?>>
                        <h1 class="text-white mb-0">Tickety</h1>
                        <p class="text-secondary mb-0">Realiable Event Booking</p>
                    </a>
                </div>
                <div class="col-lg-9">
                    <div class="d-flex justify-content-end pt-3">
                        <a class="btn btn-outline-secondary me-2 btn-md-square rounded-circle"
                            href="https://www.facebook.com/insat.rnu.tn"><i class="fab fa-facebook-f"></i></a>
                        <a class="btn btn-outline-secondary btn-md-square rounded-circle"
                            href="https://www.linkedin.com/school/national-institute-of-applied-science-and-technology/"><i
                                class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row g-5">
            <div class="col-lg-3 col-md-6">
                <div class="footer-item">
                    <h4 class="text-light mb-3">Why People Like us!</h4>
                    <p class="mb-4">
                        Customers love us for our user-friendly booking, diverse event options, fair pricing, and
                        dedicated customer service. Experience the difference!
                    </p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="d-flex flex-column text-start footer-item">
                    <h4 class="text-light mb-3">Info</h4>
                    <a class="btn-link" href=<?= "{$prefix}/contact" ?>>Contact Us</a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="d-flex flex-column text-start footer-item">
                    <h4 class="text-light mb-3">Account</h4>
                    <a class="btn-link" href=<?= "{$prefix}/userProfile" ?>>My Account</a>
                    <?php 
                        if(isset($_SESSION['role']) && $_SESSION['role'] === 'customer'):
                    ?>
                    <a class="btn-link" href=<?= "{$prefix}/view-tickets"?>>Order History</a>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="footer-item">
                    <h4 class="text-light mb-3">Contact</h4>
                    <p>Address: 676 Centre Urbain Nord BP, Tunis 1080</p>
                    <p>Email: tickety@gmail.com</p>
                    <p>Phone: (+216) 56 354 698</p>
                </div>
            </div>
        </div>
    </div>
</div>