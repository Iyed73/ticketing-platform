<?php
include 'prefix.php';


$routes = [
    "{$prefix}/" => 'src/Controllers/HomeController.php',
    "{$prefix}/home" => 'src/Controllers/HomeController.php',
    "{$prefix}/login" => 'src/Controller/LoginController.php',
    "{$prefix}/register" => 'src/Controller/RegisterController.php',
    "{$prefix}/event" => 'src/Controllers/EventPageController.php',
    "{$prefix}/contact" => 'src\Controllers\ContactFormController.php',
    "{$prefix}/customerSupport" => 'src\Controllers\CustomerSupportController.php',
];

