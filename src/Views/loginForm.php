<?php 
    require_once("../Controllers/includes/config_session.inc.php");
    require_once("loginView.php");
?>
<!doctype html>
<html lang="en">
<head>
    <title>signupForm</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="stylesheet" href="../../Static/CSS/signuploginFormStylesheet.css" />
</head>
<body>
    <main> 
        <?php outputUsername(); ?>
        <?php if(!isset($_SESSION["user_id"])): ?>
            <form action="../Controllers/loginFormHandler.php" method="post">
                <label for="username">username:</label>
                <input id="username" name="username" type="text" placeholder="username">
                <br>
                <label for="password">Password:</label>
                <input id="password" name="password" type="password" placeholder="password">
                <br>
                <button>SignUp</button>
            </form>
        <?php endif; ?>
        <?php checkLoginErrors(); ?>
        <?php checkLoginSuccess(); ?>
        <br>
        <?php if(isset($_SESSION["user_id"])): ?>
            <form action="../Controllers/logout.php" method="post">
                <button>Logout</button>
            </form>
        <?php endif; ?>
        <a href="signupForm.php">Don't have an account? Sign up here!</a>
    </main>
</body>
</html>
