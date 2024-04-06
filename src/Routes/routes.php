<?php
include 'prefix.php';


$routes = [
    "{$prefix}/" => 'src/Controllers/HomeController.php',
    "{$prefix}/home" => 'src/Controllers/HomeController.php',
    "{$prefix}/login" => 'src/Controller/LoginController.php',
    "{$prefix}/register" => 'src/Controller/RegisterController.php',
    "{$prefix}/event" => 'src/Controllers/EventPageController.php',
    "{$prefix}/all_events" => 'src/Controllers/AllEventsBoardController.php',
    "{$prefix}/event_addition" => 'src/Controllers/eventAdditionController.php',
    "{$prefix}/event_update" => 'src/Controllers/eventUpdateController.php',
    "{$prefix}/event_delete" => 'src/Controllers/eventDeleteController.php',
    "{$prefix}/all_users" => 'src/Controllers/AllUsersBoardController.php',

];

