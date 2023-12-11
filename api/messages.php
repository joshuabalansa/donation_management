<?php

include "../function.php";
require "../db-connect.php";


if (!isset($_GET['user_id']) && !isset($_GET['receiver_user_id'])) {
	returnJson([]);
}

$data = [];
$user_id = $connect->real_escape_string($_GET['user_id']);
$receiver_user_id = $connect->real_escape_string($_GET['receiver_user_id']);

$messageSql = 	"SELECT * FROM messenger " . 
				"WHERE (sender_user_id = '$user_id' AND receiver_user_id = '$receiver_user_id') " . 
					"OR (sender_user_id = '$receiver_user_id' AND receiver_user_id = '$user_id') " . 
				"ORDER BY id DESC ". 
				"LIMIT 1";

$messenger = $connect->query($messageSql);
$row = $messenger->fetch_assoc();

if (!is_null($row)) {
	$msg_id = $row['id'];
	$counter = 0;

	$messengerSql = "SELECT *, " . 
					"(SELECT name FROM users WHERE id=sender_user_id LIMIT 1) AS sender_user_name, " . 
					"(SELECT name FROM users WHERE id=receiver_user_id LIMIT 1) AS receiver_user_name " . 
					"FROM messenger_messages WHERE messenger_id='$msg_id' ORDER BY created_at ASC";
	$messenger = $connect->query($messengerSql);
	while($row = $messenger->fetch_assoc()) {
		#var_dump($row);
        $data[$counter] = [
            'id' => $row['id'],
            'msg_id' => $msg_id,
            'sender_id' => $row['sender_user_id'],
            'sender_name' => $row['sender_user_name'],
            'receiver_id' => $row['receiver_user_id'],
            'receiver_name' => $row['receiver_user_name'],
            'message' => $row['message'],
            'sent_at' => $row['seen_at'],
            'created_at' => $row['created_at']
        ];
        $counter++;
	}
}

returnJson([
	'messages' => $data,
	'my_id' => $user_id
]);
?>