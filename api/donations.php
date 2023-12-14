
<?php

include "../function.php";
require "../db-connect.php";

// if (!isset($_GET['user_id'])) {
//     returnJson([]);
// }

// $user_id = $connect->real_escape_string($_GET['user_id']);

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    returnJson($connect->query("SELECT * FROM donations")->fetch_all(MYSQLI_ASSOC));
} else {
    $data = json_decode(file_get_contents('php://input'), true);

    if (empty($data['name'] || $data['description'] || $data['phone'] || $data['email'] || $data['donationType'] || $data['donation'] || $data['image'])) {
        returnJson(["error" => "Missing required fields"]);
    }

    $sql = ($method === 'POST')
        ? "INSERT INTO donations (name, description, phone, email, donationType, donation, image) VALUES (?, ?, ?, ?, ?, ?, ?)"
        : "UPDATE donations SET name = ?, description = ?, phone = ?, email = ?, donationType = ?, donation = ?, image = ? WHERE id = ?";

    $stmt = $connect->prepare($sql);

    $bindParams = ($method === 'POST')
        ? ['sssssss', $data['name'], $data['description'], $data['phone'], $data['email'], $data['donationType'], $data['donation'], $data['image']]
        : ['sssssssi', $data['name'], $data['description'], $data['phone'], $data['email'], $data['donationType'], $data['donation'], $data['image'], $data['id']];

    $stmt->bind_param(...$bindParams);

    if ($stmt->execute()) {
        returnJson(["Message" => ($method === 'POST') ? "Data inserted successfully" : "Data updated successfully"]);
    } else {
        returnJson(["error" => "Failed to " . ($method === 'POST' ? 'insert' : 'update') . " data"]);
    }
}

if ($method === 'DELETE') {
    $data = json_decode(file_get_contents("php://input"), true);
    $stmt = $connect->prepare("DELETE FROM donations WHERE id = ?");
    $stmt->bind_param("i", $data['id']);
    $stmt->execute();

    returnJson(["message" => "Data deleted successfully"]);
}

$connect->close();

?>
