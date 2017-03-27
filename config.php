<?php
$servername = "localhost";
$user_name = "root";
$pass = "root@1";
$dbname = "chat";

	  
$conn = mysqli_connect($servername, $user_name, $pass, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}