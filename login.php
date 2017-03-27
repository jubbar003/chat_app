<?php
require("config.php");
$table = "user";

if(isset($_POST["username"]) and isset($_POST["password"])){
	$username = $_POST["username"];
	$password = $_POST["password"];
	$query = "SELECT * FROM $table WHERE username = '$username' and pwd = '$password'";
	$result = mysqli_query($conn, $query);
	$count = mysqli_num_rows($result);
	if($count == 1){
		//start new session
        session_start();

        //declare variables for session
        $_SESSION["user"] = $username;
		
		//update timestamp
		$date = date('H:i:s');
		$sql = "UPDATE user SET last_seen = '$date' WHERE username =  '$username'";
	
	    mysqli_query($conn, $sql);
		
		 header('Location: chat.php');
	}else{
		echo "Please enter correct password and username";
		header('Location: index.html');
	}}