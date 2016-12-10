<?php session_start(); /* Starts the session */

	/*If the user hasn't connected yet, go to the login page*/
	if(!isset($_SESSION['Username'])){
		header("location:php/login.php");
		exit;
	}
	
	/*If he is already connected, go to the chat page*/
	else{
		header("location:php/chat.php");
		exit;
	}
?>