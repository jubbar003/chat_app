<?php
require("config.php");
$table = "user";
$date = date('H:i:s');

$username = $_POST['user_name'];
$pwd = $_POST['pwd'];
$bio = $_POST['bio'];

$sql = "INSERT INTO $table (username, pwd, bio, last_seen)
VALUES ('$username', '$pwd', '$bio', '$date')";

if (mysqli_query($conn, $sql)) {
    
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

//start new session
session_start();

//declare variables for session
$_SESSION["user"] = $username;

 header('Location: chat.php');

?>