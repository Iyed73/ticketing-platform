<?php

ini_set('session.use_only_cookies',1);
ini_set('session.use_strict_mode',1);

session_set_cookie_params([
	'lifetime' => 60 * 30, // 30 minutes
	'domain' => 'localhost', //if you have an online site then put it's address instead 
	'path' => '/' , //means that cookies are accesssible in every path of the site
	'secure' =>true, //means that https is required for more security
    'httponly' =>true, //restrics script usage in user browser
]);

session_start();

//this is the function that will regenerate session id after certain a amount of time

function regenerate_session_id(){
    session_regenerate_id(true);
	$_SESSION["last_regenaration"] = time();
}

function regenerate_session_id_loggedin(){
	$newSessionId = session_create_id();
    $session = $newSessionId. "_" .$_SESSION["user_id"];
    session_id($session);
	$_SESSION["last_regenaration"] = time();
}
// regenrating session 
if(isset($_SESSION["user_id"])){
	if(!isset($_SESSION["last_regenaration"])){
		regenerate_session_id_loggedin();
	}else{
		$interval = 60 * 30;   // 30 is the number of minutes that will pass before regenerating a new session id
		if(time()   -   $_SESSION["last_regenaration"] >= $interval){
			regenerate_session_id_loggedin();
		}
	}
}else{
	if(!isset($_SESSION["last_regenaration"])){
		regenerate_session_id();
	}else{
		$interval = 60 * 30;   // 30 is the number of minutes that will pass before regenerating a new session id
		if(time()   -   $_SESSION["last_regenaration"] >= $interval){
			regenerate_session_id();
		}
	}
}