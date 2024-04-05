<?php
$prefix = $_ENV['prefix'];
$pathToComponents = "src/Views/";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Reset Password</title>
    <?php require_once "{$pathToComponents}Common/header.php" ?>
</head>

<body>
    <section class="all">

        <?php

        require_once "{$pathToComponents}Common/navbar.php";

        require_once "{$pathToComponents}Common/modalSearch.php";

        ?>
        <div class="container-fluid page-header py-5 " style="background-color:#293049">
            <h1 class="text-center text-white display-6">Reset Password</h1>
        </div>


        <div class="container-fluid contact py-5">
            <div class="container py-5">
                <div class="p-5 bg-light rounded">
                    <div class="row g-4">
                        <div class="col-lg-12">
                            <form action="<?= "{$prefix}/resetPassword?token={$_GET['token']}" ?>" class="contact-form" method="POST">
                                <input type="password" class="w-100 form-control border-0 py-3 mb-4" name="newPassword"
                                    placeholder="New Password" required>
                                <input type="password" class="w-100 form-control border-0 py-3 mb-4" name="newPasswordConfirm"
                                    placeholder="Confirm New Password" required>
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

    </section>

</body>

</html>