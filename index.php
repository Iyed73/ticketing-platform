<?php

include_once "src/routes/routes.php";

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);



if (array_key_exists($uri, $routes)) {
    // Data passed in URL is in $_GET array
    // if url is: "/event?id=4"--> $_GET['id'] will contain '4'
    require_once $routes[$uri];
} else {
    header("Location: {$prefix}/");
    exit;
}
