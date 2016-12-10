<?php
	/* Starts the session */
	session_start(); 
	
	/*If the user arrived at login.php from register.php, print a confirmation message of the user's registration*/
	if(isset($_SESSION['Registered']) && $_SESSION['Registered']){
		$_SESSION['Registered'] = false;
		$msg="<span style='color:green'>Registered</span>";
	}
	
	/*If the user is already online, go to the chat page*/
	if(isset($_SESSION['Username'])){
		header("location:chat.php");
		exit;
	}
	
	/*Get the last used username if it exists*/
	$CookieUsername = isset($_COOKIE["CookieUsername"]) ? $_COOKIE["CookieUsername"] : '';
	
	/* Check Login form submitted */	
	if(isset($_POST['SubmitLogin'])){
		
		/* Check and assign submitted Username and Password to new variable */
		$Username = isset($_POST['Username']) ? $_POST['Username'] : '';
		$Password = isset($_POST['Password']) ? $_POST['Password'] : '';
		
		/*Open the file containing the registered users list*/
		$myfile = fopen("../txt/users.txt", "r");
		
		/*success will stop the while loop if the login attempt is successful*/
		$success = false;

		/*Start reading users.txt line by line*/
		while(!$success && ($line = fgets($myfile)) !== false){
				
			/*currentUser[0] = current line user login
			  currentUser[1] = current line user password*/
			$currentUser = explode(";" , $line);
				
			/*if the information entered is the same as the ones of the current line, we stop the loop*/
			if ($Username == $currentUser[0] && password_verify($Password,$currentUser[1]))$success = true;
		}
		
		/*If the informations are correct*/
		if($success){

			/*Set store the username among the session variables and in a cookie */
			$_SESSION['Username']=$Username;
			setcookie("CookieUsername", $Username);
			fclose($myfile);
			
			/*Add the current user to the list of online users : online.txt*/
			$myfile = fopen("../txt/online.txt", "a+");
			fwrite($myfile, $Username."\r\n");
			fclose($myfile);
			
			header("location:../index.php");
			exit;
			
		/*If not, then we print an error message indicating a wrong login or password*/
		} else {
			$msg="<span style='color:red'>Invalid Login Details</span>";
			fclose($myfile);
		}
		
	}
?>

<form action="" method="post" name="Login_Form">
    <table width="400" border="0" align="center" cellpadding="5" cellspacing="1" class="Table">
    
    	<!--Print the success/error message if needed-->
        <?php if(isset($msg)){?>
            <tr><td colspan="2" align="center" valign="top"><?php echo $msg;?></td></tr>
        <?php } ?>
        
        <tr><td colspan="2" align="left" valign="top"><h3>Login</h3></td></tr>
        
        <tr>
            <td align="right" valign="top">Username</td>
            <td><input name="Username" type="text" class="Input" value="<?php echo $CookieUsername; ?>"></td>
        </tr>
        <tr>
            <td align="right">Password</td>
            <td><input name="Password" type="password" class="Input"></td>
        </tr>
        <tr>
            <td></td>
            <td>
            	<input name="SubmitLogin" type="submit" value="Login" class="Button3">
                <input type="button" value="Register" onclick="window.location.href='register.php'">
            </td>
        </tr>
    </table>
</form>