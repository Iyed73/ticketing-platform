<?php
//loading environment variables
require_once "vendor/autoload.php";
require_once "src/Models/autoloader.php";
require_once "configSession.inc.php";

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

include_once "src/routes/routes.php";
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
if (array_key_exists($uri, $routes)) {
    require_once $routes[$uri];
} else {
    $prefix = $_ENV['prefix'];
    header("Location: {$prefix}/");
    exit;
}
