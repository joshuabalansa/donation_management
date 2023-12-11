<?php

include "../function.php";
require "../db-connect.php";


if (!isset($_GET['user_id'])) {
	returnJson([]);
}
$user_id = $connect->real_escape_string($_GET['user_id']);

$sql = 	"SELECT *, " . 
		"(SELECT COUNT(id) FROM messenger_messages WHERE sender_user_id='$user_id' AND receiver_user_id=users.id AND seen_at IS NULL ORDER BY created_at DESC LIMIT 1) AS receiver_seen_at " . 
		"FROM users " . 
		"WHERE users.id != '$user_id' " . 
		"ORDER BY name ASC ";

/*$sql = 	"SELECT messenger.id, " . 
		"messenger.sender_user_id, " . 
		"u1.name AS sender_user_name, " . 
		"messenger.receiver_user_id, " . 
		"u2.name AS receiver_user_name, " . 
		"DATE_FORMAT(messenger.created_at, \"%b %e, %Y %H:%i\") AS updatedAt, " . 
		"(SELECT message FROM messenger_messages WHERE messenger_id=messenger.id ORDER BY created_at DESC LIMIT 1) AS message, " . 
		"(SELECT seen_at FROM messenger_messages WHERE messenger_id=messenger.id ORDER BY created_at DESC LIMIT 1) AS receiver_seen_at, " . 
		"(SELECT receiver_user_id FROM messenger_messages WHERE messenger_id=messenger.id ORDER BY created_at DESC LIMIT 1) AS message_receiver_user_id " . 
		"FROM messenger " . 
		"LEFT JOIN users AS u1 ON messenger.sender_user_id = u1.id " . 
		"LEFT JOIN users AS u2 ON messenger.receiver_user_id = u2.id " . 
		"WHERE messenger.sender_user_id != messenger.receiver_user_id " . 
			"AND (messenger.sender_user_id = '$user_id' OR messenger.receiver_user_id = '$user_id') " . 
			"ORDER BY messenger.created_at DESC ";*/
$data = [];
$counter = 0;

$result = $connect->query($sql);
while($row = $result->fetch_assoc()) {
    /*$data[$counter] = [
        'id' => $row['id'],
        'sender_id' => $row['sender_user_id'],
        'sender_name' => $row['sender_user_name'],
        'receiver_id' => $row['receiver_user_id'],
        'receiver_name' => $row['receiver_user_name'],
        'message' => $row['message'],
        'sent_at' => $row['receiver_seen_at'],
        'message_receiver_user_id' => $row['message_receiver_user_id'],
        'created_at' => $row['updatedAt']
    ];*/
    $data[$counter] = [
        'sender_id' => $user_id,
        'receiver_id' => $row['id'],
        'receiver_name' => $row['name'],
        'seen_at' => intval($row['receiver_seen_at'])
    ];
    $counter++;
}

return returnJson($data);

$connect->close();

?>