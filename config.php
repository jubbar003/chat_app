<?php
$servername = "localhost";
$user_name = "1285634";
$pass = "helloworld";
$dbname = "1285634";
	  
$conn = mysqli_connect($servername, $user_name, $pass, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}