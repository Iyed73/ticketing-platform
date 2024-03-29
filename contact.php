<!DOCTYPE html>
<html lang="en">

<head>
    <title>Contact us</title>
    <?php include 'src/Views/header.php' ?>
</head>

<body>
    <?php include 'src/Views/navbar.php' ?>

    <?php include 'src/Views/modalSearch.php' ?>

    
    <div class="container-fluid page-header py-5 " style="background-color:#293049">
        <h1 class="text-center text-white display-6">Contact</h1>
    </div>
    

    <div class="container-fluid contact py-5">
        <div class="container py-5">
            <div class="p-5 bg-light rounded">
                <div class="row g-4">

                    <div class="col-lg-7">
                        <form action="src\Views\home\contactForm.php" class="contact-form" method="POST">
                            <input type="text" class="w-100 form-control border-0 py-3 mb-4" name="name" placeholder="Your Name" required>
                            <input type="email" class="w-100 form-control border-0 py-3 mb-4" name="email" placeholder="Enter Your Email" required>
                            <input type="text" class="w-100 form-control border-0 py-3 mb-4" name="subject" placeholder="Enter the Subject" required>
                            <textarea class="w-100 form-control border-0 mb-4" rows="5" cols="10" name="message" placeholder="Your Message" required></textarea>
                            <button class="w-100 btn form-control border-secondary py-3 bg-white text-primary " type="submit">Submit</button>
                        </form>
                    </div>
                    <div class="col-lg-5">
                        <div class="d-flex p-4 rounded mb-4 bg-white">
                            <i class="fas fa-map-marker-alt fa-2x text-primary me-4"></i>
                            <div>
                                <h4>Address</h4>
                                <p class="mb-2">676 Centre Urbain Nord BP, Tunis 1080</p>
                            </div>
                        </div>
                        <div class="d-flex p-4 rounded mb-4 bg-white">
                            <i class="fas fa-envelope fa-2x text-primary me-4"></i>
                            <div>
                                <h4>Mail Us</h4>
                                <p class="mb-2">tickety@gmail.com</p>
                            </div>
                        </div>
                        <div class="d-flex p-4 rounded bg-white">
                            <i class="fa fa-phone-alt fa-2x text-primary me-4"></i>
                            <div>
                                <h4>Telephone</h4>
                                <p class="mb-2">(+216) 56 354 698</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include 'src/Views/footer.php' ?>
        
        
    <?php include 'src/Views/copyright.php' ?>
        

    <?php include 'src/Views/backToTopButton.php' ?>
        

    <?php include 'src/Views/scripts.php' ?>

</body>

</html>