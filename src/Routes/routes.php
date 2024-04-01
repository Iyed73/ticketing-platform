<?php
$prefix = '/ticketing-platform'; // change the prefix to your project directory if on xampp or to "" if running on php server

$routes = [
    "{$prefix}/home" => 'src/Controllers/HomeController.php',
    "{$prefix}/Home" => 'src/Views/home.php',
    "{$prefix}/login" => 'src/Controller/LoginController.php',
    "{$prefix}/register" => 'src/Controller/RegisterController.php',
    "{$prefix}/hello" => 'src/Views/hello.html',
]; 

