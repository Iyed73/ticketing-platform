<?php 
function autoloader($className) {
    require_once "class/$className.php";
}
spl_autoload_register("autoloader");