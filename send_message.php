<?php
$msg = $_POST['msg'];
$msg_id = $_POST['msg_id'];
$from = $_POST['from'];
$date = date('H:i:s');

require("config.php");

$table = "messages";

$sql = "INSERT INTO $table (chat_id, message, sender, time)
VALUES ('$msg_id', '$msg', '$from', '$date')";

if (mysqli_query($conn, $sql)) {
    echo "good";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}
?>