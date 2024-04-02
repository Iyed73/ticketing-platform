<?php
session_start();
session_unset();
session_destroy();
$prefix = $_ENV['prefix'];
header("Location: {$prefix}/home?logout=success");
die();