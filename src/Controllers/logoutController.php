<?php
require_once 'Services\rememberMeService.php';
session_start();

$prefix = $_ENV['prefix'];
if (!(isset($_SESSION["user_id"])&&isset($_SESSION["role"]))){
    // Redirect to home page if user is not logged in
    header("Location: {$prefix}/home");
    die();
}
// destroy remember_me cookie when user logs out
$rememberMeService = new rememberMeService();
$rememberMeService->forgetMe($_SESSION['user_id']);

session_unset();
session_destroy();
header("Location: {$prefix}/home?logout=success");
die();