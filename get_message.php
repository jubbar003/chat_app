<?php
$msg_id = $_POST['msg_id'];
require("config.php");
$table = "messages";

$sql = "SELECT message, time, sender FROM $table WHERE chat_id = '$msg_id'";
$messages = array();

$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
        $messages[] = $row;
    }
	echo json_encode($messages);
} else {
    echo "No chats available";
}
?>