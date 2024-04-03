<?php
$prefix = $_ENV['prefix'];
if (isset($_SESSION['user_id'])||isset($_SESSION['role'])){
    // Redirect to home page if user is not logged in
    header("Location: {$prefix}/home");
    die();
}
session_start();
//unset cookies
setcookie("remember_me_cookie", "", time() - 3600, "/");
session_unset();
session_destroy();
header("Location: {$prefix}/home?logout=success");
die();