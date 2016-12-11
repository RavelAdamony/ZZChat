<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>ZZChat</title>

	<script type="text/javascript" src="../js/jquery-3.1.1.js"></script>
	<script type="text/javascript" src="../js/rangyinputs-jquery.js"></script>
	<script type="text/javascript" src="../js/chat.js"></script>

	<link rel="stylesheet" type="text/css" href="../css/chat.css">
</head>

<body>
	<?php session_start();?> 
    <div class="wrap">
    	<div id="rightwrap">
        	<button type="button" name="LogoutButton" onClick="window.location.href='logout.php'">Logout</button>
        	<h1>Online users</h1>
        	<div id="onlinelist"></div>
        </div>
        <div id="chatbox"></div>
        <div class="msgbox">
            <table border="0" cellspacing="0" cellpadding="0" width="100%">
              <tr>
                <td width="20%"><input type="text" name="name" id="name" value="<?php echo $_SESSION['Username']; ?>" readonly></td>
                <td width="60%"><input type="text" name="msgfield" id="msgfield" placeholder="Enter your message here"></td>
                <td width="20%"><input type="submit" name="Submit" value="Send" class="sendbutton" onClick="sendMsg();"></td>
              </tr>
            </table>
            <a href="#" onClick="insertTag('b')"><img class="texteditbutton" src="../images/icons/bold.png"></a>
            <a href="#" onClick="insertTag('i')"><img class="texteditbutton" src="../images/icons/italic.png"></a>
            <a href="#" onClick="insertTag('u')"><img class="texteditbutton" src="../images/icons/underline.png"></a>
            <a href="#" onClick="insertTag('small')"><img class="texteditbutton" src="../images/icons/small.png"></a>
            <a href="#" onClick="insertTag('mark')"><img class="texteditbutton" src="../images/icons/highlighted.png"></a>
            <a href="#" onClick="insertTag('del')"><img class="texteditbutton" src="../images/icons/strikeout.png"></a>
            <a href="#" onClick="insertTag('sub')"><img class="texteditbutton" src="../images/icons/subscript.png"></a>
            <a href="#" onClick="insertTag('sup')"><img class="texteditbutton" src="../images/icons/superscript.png"></a>
        </div>
    </div>

    
    <script type="text/javascript">
	
        var intervalID = setInterval (function() {
            $("#chatbox").load("../php/chataction.php");
			$("#onlinelist").load("../php/onlineusers.php");
        },
        1000);
    
        var elem = document.getElementById("msgfield");
        elem.onkeyup = function(e) {
            if(e.keyCode == 13) {
                sendMsg();
            }
        }
		
    </script>
    
    </body>
</html>
