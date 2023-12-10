<?php

include "../function.php";
require "../db-connect.php";


if (isset($_POST['user_id']) && isset($_POST['receiver_user_id'])) {
	$user_id = $connect->real_escape_string($_POST['user_id']);
	$receiver_user_id = $connect->real_escape_string($_POST['receiver_user_id']);
	$message = $connect->real_escape_string($_POST['message']);

	$sql = 	"SELECT * FROM messenger " . 
			"WHERE (sender_user_id = '$user_id' AND receiver_user_id = '$receiver_user_id') " . 
				"OR (sender_user_id = '$receiver_user_id' AND receiver_user_id = '$user_id') " . 
			"ORDER BY id DESC ". 
			"LIMIT 1";

	$result = $connect->query($sql);
	$row = $result->fetch_assoc();

	if (is_null($row)) {
		$messenger_insert = $connect->query("INSERT INTO messenger (sender_user_id, receiver_user_id) VALUES ('$user_id', '$receiver_user_id')");
		$messenger_id = $connect->insert_id;
	} else {
		$messenger_id = $row['id'];
	}

	$message_insert = $connect->query("INSERT INTO messenger_messages (messenger_id, sender_user_id, receiver_user_id, message) VALUES ('$messenger_id', '$user_id', '$receiver_user_id', '$message')");
	$message_id = $connect->insert_id;
	
	return returnJson([
		'messenger_id' => $messenger_id,
		'message_id' => $message_id,
	]);
}

$connect->close();
returnJson([]);

?>