<?php

	/*If the user has just clicked a language button,
	  set the language to the corresponding value*/
	if(isSet($_GET['lang'])){
		$lang = $_GET['lang'];
		
		/*register the session and set the cookie*/
		$_SESSION['lang'] = $lang;
		setcookie('lang', $lang, time() + (3600 * 24 * 30));
	}
	
	/*If not, set the language to the language of the current/previous session*/
	else if(isSet($_SESSION['lang'])){
		$lang = $_SESSION['lang'];
	}
	
	/*If there isn't any session yet,
	set the language to the language previously saved in a cookie*/
	else if(isSet($_COOKIE['lang'])){
		$lang = $_COOKIE['lang'];
	}
	
	/*If there isn't any cookie yet,
	set the language to english*/
	else{
		$lang = 'en';
	}
	
	/*load the different texts from the file corresponding to the
	  selected language*/
	switch ($lang) {
		
		case 'en':
		$lang_file = 'lang.en.php';
		break;
		
		case 'fr':
		$lang_file = 'lang.fr.php';
		break;
		
		default:
		$lang_file = 'lang.en.php';
	}
	include_once $lang_file;
?>