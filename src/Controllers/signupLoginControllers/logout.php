<?php

session_start();
session_unset();
session_destroy();  
header("Location: /ticketing-platform/home?logout=success");
die();