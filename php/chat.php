<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>ZZChat</title>
    
    	<!-- This website uses jQuery 3.1.1 -->
        <script type="text/javascript" src="../js/jquery-3.1.1.js"></script>
        
        <!-- rangyinputs is a module able to modify some selected text in a text area
        	in this website, it will be used to edit the text of a message being typed by
            the user using different buttons-->
        <script type="text/javascript" src="../js/rangyinputs-jquery.js"></script>
        
        <!-- Added chat.js : a javascript file containing  different custom functions
        (like sending a message, modify a selected text)-->
        <script type="text/javascript" src="../js/chat.js"></script>
        
        <!-- ZZChat icon-->
        <link rel="icon" href="../images/icons/zzchat.png">
    
    	<!-- The website stylesheet -->
        <link rel="stylesheet" type="text/css" href="../css/chat.css">
    </head>

    <body>
        <?php
		
			/*Disable warning reporting*/
			error_reporting(E_ERROR | E_PARSE);
			
			/*Start the session*/
        	session_start();
			
			/*Language handling*/
			include('languages/languages.php');
			
			/*If the user hasn't connected yet, go to the login page*/
			if(!isset($_SESSION['Username'])){
				header("location:login.php");
				exit;
			}
		?> 
        
        <!-- wrap contains everything except the background (it's basically the main frame)-->
        <div class="wrap">
        
        	<!-- rightwrap contains the right part of the wrap (logout button + online users)-->
            <div id="rightwrap">
            
            	<!-- Logout button-->
                <button type="button" class="LOButton" name="LogoutButton" onClick="window.location.href='logout.php'"><?php echo $lang['LOGOUT'];?></button>
                
                <!-- List of online users-->
                <h1><?php echo $lang['ONLINE_USERS'];?></h1>
                <div id="onlinelist"></div>
          	</div>
            
            <!-- chatbox contains all of chat messages-->
            <div id="chatbox"></div>
            
            <!-- msg contains all the tools used to send a message-->
            <div class="msgbox">
            
            	<!-- to make a single line for the username display, the message field and the "send" button,
                	 all 3 will be put in a single table-->
                <table border="0" cellspacing="0" cellpadding="0" width="100%">
                  <tr>
                  
                  	<!-- Username display -->
                    <td width="20%"><input type="text" name="name" id="name" value="<?php echo $_SESSION['Username']; ?>" readonly></td>
                    
                    <!-- Message field -->
                    <td width="60%"><input type="text" name="msgfield" id="msgfield" placeholder="<?php echo $lang['MSGFIELD_PLACEHOLDER'];?>"></td>
                    
                    <!-- "Send" button -->
                    <td width="20%"><input type="submit" name="Submit" value="<?php echo $lang['SEND'];?>" class="sendbutton" onClick="sendMsg();"></td>
                  </tr>
                </table>
                
                <!-- All buttons used to modify the text being typed in the message field -->
                <a href="#" onClick="insertTag('b')"><img class="texteditbutton" src="../images/icons/bold.png"></a>
                <a href="#" onClick="insertTag('i')"><img class="texteditbutton" src="../images/icons/italic.png"></a>
                <a href="#" onClick="insertTag('u')"><img class="texteditbutton" src="../images/icons/underline.png"></a>
                <a href="#" onClick="insertTag('small')"><img class="texteditbutton" src="../images/icons/small.png"></a>
                <a href="#" onClick="insertTag('mark')"><img class="texteditbutton" src="../images/icons/highlighted.png"></a>
                <a href="#" onClick="insertTag('del')"><img class="texteditbutton" src="../images/icons/strikeout.png"></a>
                <a href="#" onClick="insertTag('sub')"><img class="texteditbutton" src="../images/icons/subscript.png"></a>
                <a href="#" onClick="insertTag('sup')"><img class="texteditbutton" src="../images/icons/superscript.png"></a>
            </div>
            
            <!-- Language buttons -->
            <div id="languageButtons">
        		<a href="#" onClick="window.location.href='chat.php?lang=eng'"><img src="../images/icons/english.png"></a>
                <a href="#" onClick="window.location.href='chat.php?lang=fr'"><img src="../images/icons/french.png"></a>
            </div>
        </div>
        </div>
    
        
        <script type="text/javascript">
        	
			/*Update the chatbox and the online users list every second*/
            var intervalID = setInterval (function() {
                $("#chatbox").load("../php/chataction.php");
                $("#onlinelist").load("../php/onlineusers.php");
            },
            1000);
        
			/*Send a message when the user presses Enter*/
            var elem = document.getElementById("msgfield");
            elem.onkeyup = function(e) {
                if(e.keyCode == 13) {
                    sendMsg();
                }
            }
            
        </script>
    
    </body>
</html>
