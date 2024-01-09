<?php

include "../function.php";
require "../db-connect.php";


if (!isset($_GET['user_id'])) {
	returnJson([]);
}
$user_id = $connect->real_escape_string($_GET['user_id']);

$checkAccessSql = "SELECT * FROM users WHERE id='$user_id' LIMIT 1";
$checkAccessResult = $connect->query($checkAccessSql);
$checkAccessRow = $checkAccessResult->fetch_assoc();

$sql = 	"SELECT *, " . 
		"(SELECT COUNT(id) FROM messenger_messages WHERE receiver_user_id='$user_id' AND sender_user_id=users.id AND seen_at IS NULL ORDER BY created_at DESC LIMIT 1) AS receiver_seen_at " . 
		"FROM users " . 
		"WHERE users.id != '$user_id' AND ";

if ($checkAccessRow['access_type'] == 'user') {
	$sql .= " access_type='admin' ";
} else {
	$sql .= " access_type='user' ";
}

if (isset($_GET['search']) && !empty($_GET['search'])) {
	$search = $connect->real_escape_string($_GET['search']);
	$sql .= "AND name LIKE \"$search%\" ";
}

$sql .= "ORDER BY name ASC LIMIT 100";

$data = [];
$counter = 0;

$result = $connect->query($sql);
while($row = $result->fetch_assoc()) {
    $data[$counter] = [
        'sender_id' => $user_id,
        'receiver_id' => $row['id'],
        'receiver_name' => $row['name'],
        'seen_at' => intval($row['receiver_seen_at']),
        'row' => $row,
    ];
    $counter++;
}

return returnJson($data);

$connect->close();

?>