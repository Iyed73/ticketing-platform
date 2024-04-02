<?php
include 'prefix.php';

$routes = [
    "{$prefix}/" => 'src\Controllers\HomeController.php',
    "{$prefix}/home" => 'src\Controllers\HomeController.php',
    "{$prefix}/login" => 'src\Controllers\loginController.php',
    "{$prefix}/register" => 'src\Controllers\RegisterController.php',
    "{$prefix}/logout" => 'src\Controllers\logoutController.php',
    "{$prefix}/event" => 'src\Controllers\EventPageController.php',
    "{$prefix}/contact" => 'src\Controllers\ContactFormController.php',
    "{$prefix}/customerSupport" => 'src\Controllers\CustomerSupportController.php',

];

