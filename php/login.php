<?php
	/* Start the session */
	session_start(); 
	
	/*Language handling*/
	include('languages/languages.php');
	
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
			include('hashequals.php');
			if ($Username == $currentUser[0] && hash_equals($currentUser[1], crypt($Password, $currentUser[1])))$success = true;
		}
		
		/*If the informations are correct*/
		if($success){

			/*Set store the username among the session variables and in a cookie */
			$_SESSION['Username']=$Username;
			setcookie("CookieUsername", $Username);
			fclose($myfile);
			
			/*Open the file containing the online users list : online.txt*/
			$myfile = fopen("../txt/online.txt", "a+");
			
			/*Remove the user from the list of online users to prevent having the same user logged twice*/
			file_put_contents("../txt/online.txt", str_replace($_SESSION['Username'] . "\r\n", "", file_get_contents("../txt/online.txt")));
			
			/*Add the user to the list of online users*/
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

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        
        <!-- ZZChat icon-->
        <link rel="icon" href="../images/icons/zzchat.png">
        
        <!-- The website stylesheet -->
        <link rel="stylesheet" type="text/css" href="../css/form.css">
        
        <title><?php echo $lang['HEADER_LOGIN'];?></title>
    </head>
    <body>
    	<div id="wrap">
            <form action="" method="post" name="Login_Form">
                <table width="800" border="0" align="center" cellpadding="5" cellspacing="1" class="Table">
                
                    <!--Success/error message field-->
                    <?php if(isset($msg)){?>
                        <tr><td colspan="2" align="center" valign="top"><?php echo $msg;?></td></tr>
                    <?php } ?>
                    
                    <!-- Title : Login -->
                    <tr>
                    	<td colspan="2" align="center" valign="top">
                            <div class="Title"><?php echo $lang['LOGIN'];?></div>
                            <link href="https://fonts.googleapis.com/css?family=Yanone+Kaffeesatz" rel="stylesheet">
                        </td>
                    </tr>
                    
                    <!-- Username field -->
                    <tr>
                        <td align="Right" width="40%"><h3><?php echo $lang['USERNAME'];?></h3></td>
                        <td align="left" width="60%"><input name="Username" type="text" class="Input" value="<?php echo $CookieUsername; ?>"></td>
                    </tr>
                    
                    <!-- Password field -->
                    <tr>
                        <td align="Right"><h3><?php echo $lang['PASSWORD'];?></h3></td>
                        <td align="left"><input name="Password" type="password" class="Input"></td>
                    </tr>
                    
                    <!-- Buttons -->
                    <tr>
                        <td align="Right"><input name="SubmitLogin" class = "MButton" type="submit"  value="<?php echo $lang['LOGIN'];?>" class="Button3"></td>
                 
                        <!-- Go to the register page -->
                        <td align="left"><input type="button"  class = "MButton" value="<?php echo $lang['LOGIN_TO_REGISTER'];?>" onclick="window.location.href='register.php'"></td>
                    </tr>
                </table>
                
                <!-- Language buttons -->
                <div id="languageButtons">
                    <a href="#" class="Lbutton" onClick="window.location.href='login.php?lang=eng'"><img class="Lbutton" src="../images/icons/english.png"></a>
                    <a href="#" class="Lbutton" onClick="window.location.href='login.php?lang=fr'"><img class="Lbutton" src="../images/icons/french.png"></a>
                </div>
            </form>
		</div>
    </body>
</html>