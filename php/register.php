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
				$hashedPwd = crypt($Password);
				
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
        
        <!-- ZZChat icon-->
        <link rel="icon" href="../images/icons/zzchat.png">
        
        <!-- The website stylesheet -->
        <link rel="stylesheet" type="text/css" href="../css/form.css">
        
        <title><?php echo $lang['HEADER_REGISTER'];?></title>
    </head>
    <body>
    	<div id="wrap">
            <form action="" method="post" name="Register_Form">
                <table width="800" border="0" align="center" cellpadding="5" cellspacing="1" class="Table">
                
                    <!--Success/error message field-->
                    <?php if(isset($msg)){?>
                        <tr><td colspan="2" align="center" valign="top"><?php echo $msg;?></td></tr>
                    <?php } ?>
                    
                    <!-- Title : Register -->
                    <tr>
                        <td colspan="2" align="left" valign="top">
                        	<div class="Title"><?php echo $lang['REGISTER'];?></div>
                            <link href="https://fonts.googleapis.com/css?family=Yanone+Kaffeesatz" rel="stylesheet">
                        </td>
                    </tr>
                    
                    <!-- Username field -->
                    <tr>
                        <td align="right" width="40%"><h3><?php echo $lang['USERNAME'];?></h3></td>
                        <td align="left" width="60%"><input name="Username" type="text" class="Input"></td>
                    </tr>
                    
                    <!-- Password field -->
                    <tr>
                        <td align="right"><h3><?php echo $lang['PASSWORD'];?></h3></td>
                        <td align="left"><input name="Password" type="password" class="Input"></td>
                    </tr>
                    
                    <!-- Confirm password field -->
                    <tr>
                        <td align="right"><h3><?php echo $lang['CONFIRM_PASSWORD'];?></h3></td>
                        <td align="left"><input name="ConfirmPassword" type="password" class="Input"></td>
                    </tr>
                    
                    <!-- Buttons -->
                    <tr>
                        <!-- Register Button -->
                        <td align="right"><input name="Submit" class="MButton" type="submit" value="<?php echo $lang['REGISTER'];?>" class="Button3"></td>
                        
                        <!-- Go to the login page -->
                        <td align="left"><input type="button" class="MButton" value="<?php echo $lang['REGISTER_TO_LOGIN'];?>" onclick="window.location.href='login.php'"></td>
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