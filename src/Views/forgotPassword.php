<?php
$pathToComponents = 'src/Views/';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Forgot Password</title>
    <?php require_once "{$pathToComponents}Common/header.php" ?>
</head>

<body>
    <?php

    require_once "{$pathToComponents}Common/loadingSpinner.php";

    require_once "{$pathToComponents}Common/navbar.php";

    require_once "{$pathToComponents}Common/modalSearch.php";

    ?>

    <br>
    <br>
    <br>
    <div class="container-fluid contact py-5 mt-5">
        <div class="container py-5">
            <div class="p-5 bg-light rounded">
                <div class="row g-4">

                    <div class="col-lg-12">
                        <form action="<?= "{$prefix}/forgotPassword" ?>" class="contact-form" method="POST">
                            <label for="email" class="form-label">Enter your email address to receive a recovery
                                link:</label>
                            <input type="text" class="w-100 form-control border-0 py-3 mb-4" name="email"
                                placeholder="Your Email" required>
                            <?php if (isset($response)): ?>
                                <?php if (strpos($response, 'error') !== false): ?>
                                    <div class='alert alert-danger' role='alert'>
                                        <?= $response ?>
                                    </div>
                                <?php else: ?>
                                    <div class='alert alert-success' role='alert'>
                                        <?= $response ?>
                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>
                            <button class="w-100 btn form-control border-secondary py-3 bg-white text-primary "
                                type="submit">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php

    require_once "{$pathToComponents}Common/footer.php";

    require_once "{$pathToComponents}Common/copyright.php";

    require_once "{$pathToComponents}Common/backToTopButton.php";

    require_once "{$pathToComponents}Common/scripts.php";

    ?>
</body>

</html>