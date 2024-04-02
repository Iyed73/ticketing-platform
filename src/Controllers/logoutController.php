<?php
session_start();
session_unset();
session_destroy();
include 'prefix.php';
header("Location: {$prefix}/home?logout=success");
die();