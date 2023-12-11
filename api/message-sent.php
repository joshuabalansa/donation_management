<?php

include "../function.php";
require "../db-connect.php";


if (isset($_POST['user_id']) && isset($_POST['receiver_user_id'])) {
	//var_dump($_POST);exit();
	$user_id = $connect->real_escape_string($_POST['user_id']);
	$receiver_user_id = $connect->real_escape_string($_POST['receiver_user_id']);
	$message = $connect->real_escape_string($_POST['message']);
	//var_dump($receiver_user_id);var_dump($user_id);var_dump($message);exit();

	$sql = 	"SELECT * FROM messenger " . 
			"WHERE (sender_user_id = '$user_id' AND receiver_user_id = '$receiver_user_id') " . 
				"OR (sender_user_id = '$receiver_user_id' AND receiver_user_id = '$user_id') " . 
			"ORDER BY id DESC ". 
			"LIMIT 1";

	$result = $connect->query($sql);
	$row = $result->fetch_assoc();

	if (is_null($row)) {
		$messenger_insert = $connect->query("INSERT INTO messenger (sender_user_id, receiver_user_id, created_at) VALUES ('$user_id', '$receiver_user_id', NOW())");
		if ($messenger_insert === TRUE) {
			$messenger_id = $connect->insert_id;
		} else {
			returnJson(['Error' => $connect->error]);
		}
	} else {
		$messenger_id = $row['id'];
	}

	$message_insert = $connect->query("INSERT INTO messenger_messages (messenger_id, sender_user_id, receiver_user_id, message, created_at) VALUES ('$messenger_id', '$user_id', '$receiver_user_id', '$message', NOW())");
	$message_id = $connect->insert_id;
	
	if ($message_insert === TRUE) {
		$messenger_id = $connect->insert_id;
	} else {
		returnJson(['Error' => $connect->error]);
	}
	return returnJson([
		'messenger_id' => $messenger_id,
		'message_id' => $message_id,
	]);
}

$connect->close();
returnJson([]);

?>