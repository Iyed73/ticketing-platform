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
    "{$prefix}/all_events" => 'src/Controllers/AllEventsBoardController.php',
    "{$prefix}/event_addition" => 'src/Controllers/eventAdditionController.php',
    "{$prefix}/event_update" => 'src/Controllers/eventUpdateController.php',
    "{$prefix}/event_delete" => 'src/Controllers/eventDeleteController.php',
    "{$prefix}/all_users" => 'src/Controllers/AllUsersBoardController.php',
    "{$prefix}/forgotPassword" => 'src/Controllers/ForgotPasswordController.php',
    "{$prefix}/recoverPassword" => 'src/Controllers/RecoverPasswordController.php',
    "{$prefix}/resetPassword" => 'src/Controllers/ResetPasswordController.php',
    "{$prefix}/verify" => 'src/Controllers/VerifyAccountController.php',
    "{$prefix}/reserve" => 'src/Controllers/EventReservationController.php',
    "{$prefix}/payment" => 'src/Controllers/PaymentController.php',
    "{$prefix}/cancel" => 'src/Controllers/CancelReservationController.php',
    "{$prefix}/view-tickets" => 'src/Controllers/TicketsPageController.php',
    "{$prefix}/ticket" => 'src/Controllers/TicketPDFController.php',
    "{$prefix}/userProfile" => 'src\Controllers\ChangeAccountInfoControler.php',
    "{$prefix}/changePassword" => 'src\Controllers\ChangePasswordController.php',
    "{$prefix}/notifications" => 'src\Controllers\NotificationController.php',
    "{$prefix}/set_currency" => 'src\Controllers\SetCurrencyController.php',
];

