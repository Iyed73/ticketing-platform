<?php
$prefix = $_ENV['prefix'];

$routes = [
    "{$prefix}/" => 'src\Controllers\HomeController.php',
    "{$prefix}/home" => 'src\Controllers\HomeController.php',
    "{$prefix}/login" => 'src\Controllers\loginController.php',
    "{$prefix}/register" => 'src\Controllers\RegisterController.php',
    "{$prefix}/logout" => 'src\Controllers\logoutController.php',
    "{$prefix}/event" => 'src\Controllers\EventPageController.php',
    "{$prefix}/search" => 'src/Controllers/SearchController.php',
    "{$prefix}/contact" => 'src\Controllers\ContactFormController.php',
    "{$prefix}/customerSupport" => 'src\Controllers\CustomerSupportController.php',
    "{$prefix}/deleteSubmission" => 'src\Controllers\DeleteSubmissionController.php',
    "{$prefix}/forgotPassword" => 'src/Controllers/ForgotPasswordController.php',
    "{$prefix}/recoverPassword" => 'src/Controllers/RecoverPasswordController.php',
    "{$prefix}/resetPassword" => 'src/Controllers/ResetPasswordController.php',
    "{$prefix}/verify" => 'src/Controllers/VerifyAccountController.php',
];

