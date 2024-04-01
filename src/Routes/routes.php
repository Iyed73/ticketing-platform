<?php

require_once 'src/Views/prefix.php';


$routes = [
    "{$prefix}/home" => 'src/Controllers/HomeController.php',
    "{$prefix}/login" => 'src/Controllers/LoginController.php',
    "{$prefix}/register" => 'src/Controllers/RegisterController.php',
    "{$prefix}/event" => 'src/Controllers/EventPageController.php',
]; 
