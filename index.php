<?php

include_once "src/routes/routes.php";

$uri = $_SERVER['REQUEST_URI'];

if ($uri === '/') {
    header('Location: /home');
    exit;
}

if (array_key_exists($uri, $routes)) {
    // Data passed in URL is in $_GET array
    // if url is: "/event?id=4"--> $_GET['id'] will contain '4'
    require_once $routes[$uri];
} else {
    http_response_code(404);
}
