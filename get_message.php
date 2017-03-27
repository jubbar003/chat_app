<?php
$msg_id = $_POST['msg_id'];
require("config.php");
$table = "messages";

$sql = "SELECT message, time, sender FROM $table WHERE chat_id = '$msg_id''";
$array = array();

if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
        $array[] = $row;
    }
	echo json_encode($array);
} else {
    echo "No chats available";
}
?>