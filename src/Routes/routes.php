<?php
include 'prefix.php';


$routes = [
    "{$prefix}/" => 'src/Controllers/HomeController.php',
    "{$prefix}/home" => 'src/Controllers/HomeController.php',
    "{$prefix}/login" => 'src/Controller/LoginController.php',
    "{$prefix}/register" => 'src/Controller/RegisterController.php',
    "{$prefix}/event" => 'src/Controllers/EventPageController.php',
    "{$prefix}/reserve" => 'src/Controllers/EventReservationController.php',
    "{$prefix}/payment" => 'src/Controllers/PaymentController.php',
    "{$prefix}/cancel" => 'src/Controllers/CancelReservationController.php',
    "{$prefix}/view-tickets" => 'src/Controllers/TicketsPageController.php',
    "{$prefix}/ticket" => 'src/Controllers/TicketPDFController.php',
];

