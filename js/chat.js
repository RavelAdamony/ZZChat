// sendMsg : called each time a message is added to the chat from chat.php
function sendMsg() {

	/*Get message and nickname from chat.php*/
	var chMsg = $("#msgfield").val();	
	var chname = $("#name").val();

	/*If both aren't empty*/
	if (chMsg != "" && chname != "") {
		
		/*Encode the message and nickname and treat them with chataction.php*/ 
		chMsg = encodeURI(chMsg);
		chname = encodeURI(chname);
		$("#chatbox").load("../php/chataction.php?msg="+chMsg+"&name="+chname);
		
		/*Reset the message field*/
		$("#msgfield").val("");
		$("#msgfield").focus();
		
	/*If the message field is empty, , we don't do anything*/	
	} else {
		$("#msgfield").focus();
	}
	
	/*If after the message is added, the chatbox is full, we scroll down*/
	$("#chatbox").animate({ scrollTop: $(document).height() }, "slow");
}

function insertTag(tag) {
	var selection = $("#msgfield").getSelection().text;
	$("#msgfield").replaceSelectedText('<'+tag+'>' + selection + '</'+tag+'>');
}