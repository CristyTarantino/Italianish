<?php 
//initialise the session
if(!isset($_SESSION)){
	session_start();
}

//clear the session array
$_SESSION = array();

//destroy the session data on the server
session_destroy();

//redirect the user to the login page.
header("location:login.php?loggedout=True");
?>