<?php

$request_uri = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : null;
//echo $request_uri;  for testing purposes

//the actual rout directory is actually /ticketing-platform/ not /
//so we need to check if the request uri is /ticketing-platform/ or /ticketing-platform/home/ or /ticketing-platform/home
if ($request_uri === '/ticketing-platform/' || $request_uri === '/ticketing-platform/home/' || $request_uri === '/ticketing-platform/home') {
	
	$route = '\src\Controllers\HomeController.php';
	
} elseif ($request_uri === '/ticketing-platform/Home' || $request_uri === '/ticketing-platform/Home/') {
	
	$route = '\src\Views\home.php';
	
}else {
	
	$route = '\404.php';
	
}

require __DIR__ . $route;