<?php

include "../function.php";
require "../db-connect.php";


if (isset($_GET['user_id'])) {
	$user_id = $connect->real_escape_string($_GET['user_id']);

	$sql = 	"SELECT messenger.id, " . 
			"messenger.sender_user_id, " . 
			"u1.name AS sender, " . 
			"messenger.receiver_user_id, " . 
			"u2.name AS receiver, " . 
			"DATE_FORMAT(messenger.created_at, \"%b %e, %Y %H:%i\") AS updatedAt, " . 
			"(SELECT message FROM messenger_messages WHERE messenger_id=messenger.id ORDER BY created_at DESC LIMIT 1) AS message, " . 
			"(SELECT seen_at FROM messenger_messages WHERE messenger_id=messenger.id ORDER BY created_at DESC LIMIT 1) AS receiver_seen_at, " . 
			"(SELECT receiver_user_id FROM messenger_messages WHERE messenger_id=messenger.id ORDER BY created_at DESC LIMIT 1) AS message_receiver_user_id " . 
			"FROM messenger " . 
			"LEFT JOIN users AS u1 AS messenger.sender_user_id = u1.id " . 
			"LEFT JOIN users AS u2 AS messenger.receiver_user_id = u2.id " . 
			"WHERE u1.deleted_at IS NULL " . 
				"AND u2.deleted_at IS NULL " . 
				"AND messenger.sender_user_id != messenger.receiver_user_id " . 
				"AND (messenger.sender_user_id = '$user_id' OR messenger.receiver_user_id = '$user_id') " . 
				"ORDER BY messenger.created_at DESC ";

	$result = $connect->query($sql);
	
	return returnJson($result);
}

$connect->close();
returnJson([]);

?>