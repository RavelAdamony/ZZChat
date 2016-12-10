<?php

	/* Starts the session */
	session_start(); 
	
	/*Open the file containing the registered users list*/
	$myfile = fopen("../txt/online.txt", "r+");
	
	/*Remove the user from the list of online users*/
	file_put_contents("../txt/online.txt", str_replace($_SESSION['Username'] . "\r\n", "", file_get_contents("../txt/online.txt")));
	
	/* Destroy the current session */
	session_destroy();
	
	/* Redirect to login page */
	header("location:login.php");
	exit;
?>