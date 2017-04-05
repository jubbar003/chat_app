<?php
session_start(); 
if ($_SESSION["user"]) {

	require("config.php");
	
$table = "user";


// Create connection
$conn = mysqli_connect($servername, $user_name, $pass, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
	
	$date = date('H:i:s');
	$username = $_SESSION['user'];
	
	$sql = "UPDATE user SET last_seen = '$date' WHERE username =  '$username'";
	
	if(mysqli_query($conn, $sql)){
	}else{
		echo "Error: " . $sql . "<br>" . mysqli_error($conn);
	}
}

?>