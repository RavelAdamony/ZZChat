<?php
	/* Start the session */
	session_start(); 
	
	/* Check if the register form has been submitted */	
	if(isset($_POST['Submit'])){
		
		/* Check and assign submitted Username and Password to new variable */
		$Username = isset($_POST['Username']) ? $_POST['Username'] : '';
		$Password = isset($_POST['Password']) ? $_POST['Password'] : '';
		$ConfirmPassword = isset($_POST['ConfirmPassword']) ? $_POST['ConfirmPassword'] : '';

		/* If the password has been confirmed */		
		if ( trim($Username) !== '' && trim($Password) !== '' && $Password == $ConfirmPassword){
			
			/*stop will stop the while loop if needed*/
			$stop = false;
			
			/*Open the file containing the registered users list*/
			$myfile = fopen("../txt/users.txt", "r+");
			
			/*Start reading the whole users.txt file to check if the user already exists*/
			while(!$stop && ($line = fgets($myfile)) !== false){
				
				/*currentUser[0] = current line user login*/
				$currentUser = explode(";" , $line);
				
				/*if the user already exists, we stop the loop*/
				if ($Username == $currentUser[0])$stop = true;
			}
			
			/*If the username doesn't exist yet, we add the user to the users list*/
			if (!$stop){
				
				/*Hash the password*/
				$hashedPwd = password_hash($Password, PASSWORD_DEFAULT);
				
				/*Add the user to users.txt*/
				fwrite($myfile, $Username. ";" . $hashedPwd . ";\r\n");
				fclose($myfile);
				
				/*Go to the login page*/
				$_SESSION['Registered']=true;
				header("location:login.php");
				exit;
			}
			
			/*If not, we print an error message indicating an already used nickname*/
			else {
				$msg="<span style='color:red'>Username already taken</span>";
				fclose($myfile);
			}
		
		/*If not, we print an error message about invalid login details*/	
		} else $msg="<span style='color:red'>Invalid Login Details</span>";
	}
?>

<form action="" method="post" name="Register_Form">
    <table width="400" border="0" align="center" cellpadding="5" cellspacing="1" class="Table">
    
        <?php if(isset($msg)){?>
            <tr><td colspan="2" align="center" valign="top"><?php echo $msg;?></td></tr>
        <?php } ?>
        
        <tr>
            <td colspan="2" align="left" valign="top"><h3>Register</h3></td></tr>
        <tr>
            <td align="right" valign="top">Username</td>
            <td><input name="Username" type="text" class="Input"></td>
        </tr>
        <tr>
            <td align="right">Password</td>
            <td><input name="Password" type="password" class="Input"></td>
        </tr>
                <tr>
            <td align="right">Confirm Password</td>
            <td><input name="ConfirmPassword" type="password" class="Input"></td>
        </tr>
        <tr>
            <td></td>
            <td><input name="Submit" type="submit" value="Login" class="Button3"></td>
        </tr>
    </table>
</form>