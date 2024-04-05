<?php
include 'prefix.php';


$routes = [
    "{$prefix}/" => 'src/Controllers/HomeController.php',
    "{$prefix}/home" => 'src/Controllers/HomeController.php',
    "{$prefix}/login" => 'src/Controller/LoginController.php',
    "{$prefix}/register" => 'src/Controller/RegisterController.php',
    "{$prefix}/event" => 'src/Controllers/EventPageController.php',
    "{$prefix}/dashboard" => 'src/Controllers/DashboardController.php',
    "{$prefix}/event_addition" => 'src/Controllers/eventAdditionController.php',
    "{$prefix}/dashboard/event_update" => 'src/Controllers/eventUpdateController.php',

];

