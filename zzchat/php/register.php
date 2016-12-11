<?php
	/* Start the session */
	session_start();
	
	/*Language handling*/
	include('languages/languages.php');
	
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

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        
        <!-- The website stylesheet -->
        <link rel="stylesheet" type="text/css" href="../css/register.css">
        
        <title><?php echo $lang['HEADER_REGISTER'];?></title>
    </head>
    <body>
    	<div id="wrap">
            <form action="" method="post" name="Register_Form">
                <table width="500" border="0" align="center" cellpadding="5" cellspacing="1" class="Table">
                
                    <!--Success/error message field-->
                    <?php if(isset($msg)){?>
                        <tr><td colspan="2" align="center" valign="top"><?php echo $msg;?></td></tr>
                    <?php } ?>
                    
                    <!-- Login -->
                    <tr>
                        <td colspan="2" align="left" valign="top"><h3><?php echo $lang['REGISTER'];?></h3></td>
                    </tr>
                    
                    <!-- Username field -->
                    <tr>
                        <td align="right" valign="top"><?php echo $lang['USERNAME'];?></td>
                        <td><input name="Username" type="text" class="Input"></td>
                    </tr>
                    
                    <!-- Password field -->
                    <tr>
                        <td align="right"><?php echo $lang['PASSWORD'];?></td>
                        <td><input name="Password" type="password" class="Input"></td>
                    </tr>
                    
                    <!-- Confirm password field -->
                    <tr>
                        <td align="right"><?php echo $lang['CONFIRM_PASSWORD'];?></td>
                        <td><input name="ConfirmPassword" type="password" class="Input"></td>
                    </tr>
                    
                    <!-- Buttons -->
                    <tr>
                        <td></td>
                        <td>
                            <!-- Register Button -->
                            <input name="Submit" type="submit" value="<?php echo $lang['REGISTER'];?>" class="Button3">
                            
                            <!-- Go to the login page -->
                            <input type="button" value="<?php echo $lang['REGISTER_TO_LOGIN'];?>" onclick="window.location.href='login.php'">
                        </td>
                    </tr>
                </table>
            </form>
            
             <!-- Language buttons -->
            <div id="languageButtons">
        		<a href="#" class="Lbutton" onClick="window.location.href='register.php?lang=eng'"><img src="../images/icons/english.png"></a>
                <a href="#" class="Lbutton" onClick="window.location.href='register.php?lang=fr'"><img src="../images/icons/french.png"></a>
            </div>
        </div>
	</body>
</html>