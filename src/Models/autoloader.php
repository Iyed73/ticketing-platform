<?php
// Define autoload functions
function autoload_models($class) {
    $classmapFile = "src/Models/" . $class . '.php';
    if (file_exists($classmapFile)) {
        include_once $classmapFile;
    }
}
spl_autoload_register('autoload_models');

