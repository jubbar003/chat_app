<?php
session_start();
 if(isset($_SESSION["user"])){
 }else{
	 header('Location: index.html');
 }

 require("config.php");
$table = "user";
$table2 = "registred_chats";
//set up db class
require 'DB.php';
$db = new DB();
 ?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Streamline Chat</title>
<!-- Include meta tag to ensure proper rendering and touch zooming -->
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- Include jQuery Mobile stylesheets -->
<link rel="stylesheet" href="https://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css">

<!-- Include the jQuery library -->
<script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>

<!-- Include the jQuery Mobile library -->
<script src="https://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>

<link rel="stylesheet" href="style.css">
<style>
	
	.ui-panel.ui-panel-open {
    position:fixed;
}
.ui-panel-inner {
    position: absolute;
    top: 1px;
    left: 0;
    right: 0;
    bottom: 0px;
    overflow: auto;
    -webkit-overflow-scrolling: touch;
}
  .ui-content {
  margin-top:100px;
  margin-left:400px;
  margin-right:400px;
}

#chats{
	background-color:#FFFFFF;
	border: 2px solid #000;
    border-radius: 15px;
    -moz-border-radius: 15px;
	padding: 5px;
}

/* For mobile screens */
@media screen and (max-width: 480px) {
    .ui-content{
		margin:0px;
}
</style>
</head>

<body>
<div data-role="page" id="chat">
<div data-role="header">
<a href="#panel1" class="ui-btn-left ui-btn ui-btn-inline ui-mini ui-corner-all ui-btn-icon-left ui-icon-gear">Options</a>
<h1>Streamline Chat</h1>
<a data-ajax="false" href="logout.php" class="ui-btn ui-btn-inline ui-mini ui-corner-all ui-btn-icon-right ui-icon-power">Log Out</a>
</div>
  <div data-role="main" class="ui-content">
   <?php
	  //check it chat_mate is selected, else display other message.
	 if(isset($_GET['chat_mate'])){
		 //get chat member details and display the bio
		 $chatmate = $_GET['chat_mate'];
		 $chat_id = $chatmate . $_SESSION["user"];
		 $chat_mate_bio = $db->getName($table, $chatmate, "bio", "username");
		 echo "<h3>Chatting with: " . $chatmate ."</h3>";
		 echo "<h3>About " . $chatmate ."</h3>";
		 echo "<p>" . $chat_mate_bio . "</p>";
		 /*if($db->getName($table2, $chat_id, "chat_id", "chat_id") == 0){
			 //chat does not appear
			 $chat_id = $chat_id_temp;
		 }*/
		 //if there is any history, display it all, else display message of no other chats.
		 // you are all done
	 }else{
		 $chatmate = "";
		 $chat_id = "";
		 echo "<h3>Please select a person to chat with from the options menu in the left-hand corner.</h3>";
	 }
   ?>
   <div id="chats"></div>
   <textarea cols="40" rows="8" name="msg" id="msg" placeholder="Message here..."></textarea>
   <input type="button" data-inline="true" id="submit" value="Submit">
  </div>
  <div data-role="panel" id="panel1">
  <p style="color: #08A049">Currently logged in as <?php echo $_SESSION["user"]; ?></p>
  <h2>Members Online</h2>
  <input type="hidden" value="<?php echo $_SESSION["user"]; ?>" id="user"/>
  <input type="hidden" value="<?php echo $chatmate ?>" id="chatmate"/>
  <input type="hidden" value="<?php echo $chat_id ?>" id="chat_id"/>
  <form class="ui-filterable">
  	<input id="member_filter" data-type="search" placeholder="Search for members...">
  </form>
  <ol data-role="listview" data-inset="true" id="m_on" data-filter="true" data-input="#member_filter" data-autodividers="true">
  	<li data-role="list-divider"></li>
  	<?php
	  $delay = date('H:i:s', strtotime("-5 minute"));
	  $query = "SELECT username FROM $table WHERE last_seen > '" . $delay . "' ORDER BY username ASC";
	  $result = mysqli_query($conn, $query);
	$count = mysqli_num_rows($result);
	  if($count >= 1){
		  while($row = mysqli_fetch_assoc($result)) {
		foreach ( $row as $key => $value){
			if($value != $_SESSION["user"]){
				echo "<li>" . $value . "</li>";
			}elseif($value == $_SESSION["user"] && $count == 1){
				echo "No members online.";
			}
		}
    }
	  }else{
				echo "<li>No members online</li>";
			}
	?>
  </ol>
  <h2>Previous Chats</h2>
  <ol data-role="listview" data-inset="true">
  	<li data-role="list-divider"></li>
  	<li>No previous chats</li>
  	<?php
$table = "user";
	  
	  
	?>
  </ol>
  </div>
</div>
<script> 
	
	$(document).on("pageinit",function(event){
		setInterval(update, 10000);
		setInterval(getMessage, 20000);
		
		$( "#submit" ).bind( "click", function() {
			//get message
			var msg_display = $("#msg").val();
			//get chat_id, if not set, display an alert of not able to send, please select chat member
			var chat_id = $("#chat_id").val();
			//get user_id
			var user = $("#user").val();
			if(chat_id != ""){
				//send message
			  sendMessage(msg_display, chat_id, user);	
			}else{
				alert("Please select a user to chat with");
				$("#msg").val("");
			}
});
		
		$( "#m_on li" ).bind( "click", function() {
          var selected_member = $(this).html();
			if(selected_member != "No members online"){
				window.location = 'chat.php?chat_mate=' + selected_member;
			}
			//reload this page with the values of member to chat with
});
		
		
		
		function update() { 
	 $.ajax({
		 type: 'POST',
		   url: "update.php",
		   success: function(result){
			   //all good.
		   }
	 })
 }
		function sendMessage(msg, msg_id, from){
		   $.ajax({
		 type: 'POST',
		   url: "send_message.php",
		   data: {msg:msg, msg_id:msg_id, from:from},
		   success: function(result){
			   if(result == "good"){
				   getMessage(msg_id);
			   }else{
				   alert("Not able to send message " + result);
			   }
		   }
	 })
		}
		
		function getMessage(msg_id){
		   $.ajax({
		 type: 'POST',
		   url: "get_message.php",
		   data: {msg_id:msg_id},
		   dataType: "json",
		   success: function(result){
			   //all good.
			   ///append to the chats.
			   for(var i=0; i < result.length; i++){
				   $("#chats").append("<p>" + result[i]['message'] + "</p>" +
									  "<p align=right>Sent by " + result[i]['sender'] + " at " + 
	                                   result[i]['time'] + "</p>");
			   }
			   $("#msg").val("");
		       $('#chats').animate({scrollTop:$('#chats').prop("scrollHeight")}, 500);
		   }
	 })
		}
});
</script>
</body>
</html>