<?php

	/*Disable error reporting*/
	error_reporting(0);

	/*Get message and nickname from chat.js*/
	$msg = addslashes($_REQUEST['msg']);
	$name = addslashes($_REQUEST['name']);

	/*If both aren't empty*/
	if ($msg != "" && $name != "") {

		/*Open chat.txt, containing all messages*/
		$myfile = fopen("../txt/chat.txt", "a") or die("Unable to open file!");

		/*Create a new line to be added to the chat in this form : "nickname:message"*/
		$msg = "<li><strong>".$name."</strong>: ".$msg."</li>";

		/*Append this line to chat.txt*/
		fwrite($myfile, "". $msg ."\r\n");
		fclose($myfile);
	}
?>

<!--Print all messages in the chatbox-->
<ul>
	<?php echo file_get_contents("../txt/chat.txt"); ?>
</ul>