<?php
include "prefix.php";
session_start();
session_unset();
session_destroy();  
//header("Location: {$prefix}/home?logout=success");
header("Location: /ticketing-platform/home?logout=success");
die();