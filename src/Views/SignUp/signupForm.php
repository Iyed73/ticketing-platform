<?php 
    require_once("../../Controllers/includes/configSession.inc.php");
    require_once("signupView.php")
?>
<!doctype html>
<html lang="en">
<head>
    <title>signupForm</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="stylesheet" href="../../../Static/CSS/signuploginFormStylesheet.css" />
</head>
<body>
    <main> 
        <form action="../Controllers/signupFormHandler.php" method="post">
            <?php signupInput(); ?>
            <button>SignUp</button>
        </form>
        <?php checkSignupErrors(); ?>
        <?php checkSignupSuccess(); ?>
        <?php
            if(isset($_GET["signup"])){
                if($_GET["signup"]=="success"){
                    header("Refresh:2; url=loginForm.php");
                }
            }
        ?>
    </main>
</body>
</html>
