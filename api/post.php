<?php 

include "../function.php";
require "../db-connect.php";

/**
 * Post rest API
 */


if (!isset($_GET['user_id'])) {
	returnJson([]);
}

$user_id = $connect->real_escape_string($_GET['user_id']);

$method = $_SERVER['REQUEST_METHOD'];

if($method === 'GET') {
    $result = $connect->query("SELECT * FROM posts");
    
    $data = array();
    while($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    returnJson($data);

} elseif ($method == 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);


    if (empty($data['title']) || empty($data['description']) || empty('phone') || empty($data['email']) || empty($data['address']) || empty($data['image'])) {
        returnJson(array(
            "error" => "Missing required fields"
        ));
    } else {

        $sql = "INSERT INTO posts (title, description, phone, email, address, image) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $connect->prepare($sql);
        $stmt->bind_param("ssssss", $data['title'], $data['description'], $data['phone'], $data['email'], $data['address'], $data['image']);

        if ($stmt->execute()) {
            returnJson(array(
                "message" => "Data inserted Successfully"
            ));
        } else {
            returnJson(array(
                "error" => "Failed to insert data"
            ));
        }
    }
} elseif ($method == 'PUT') {
    $data = json_decode(file_get_contents("php://input"), true);

    if (empty($data['title']) || empty($data['description']) || empty($data['phone']) || empty($data['email']) || empty($data['address']) || empty($data['image'])) {
        returnJson(array(
            "error" => "Missing required fields"
        ));
    } else {
      
        $sql = "UPDATE posts SET title = ?, description = ?, phone = ?, email = ?, address = ?, image = ? WHERE id = ?";
        $stmt = $connect->prepare($sql);
        $stmt->bind_param('ssssssi', $data['title'], $data['description'], $data['phone'], $data['email'], $data['address'], $data['image'], $data['id']);

        if ($stmt->execute()) {
            returnJson(array(
                "message" => "Data updated successfully"
            ));
        } else {
            returnJson(array(
                "message" => "Failed to update data"
            ));
        }
    }
} elseif ($method === 'DELETE') {
   
    $data = json_decode(file_get_contents("php://input"), true);
    $stmt = $connect->prepare("DELETE FROM posts WHERE id = ?");
    $stmt->bind_param("i", $data['id']);
    $stmt->execute();

    echo json_encode(array("message" => "Data deleted successfully"));
}

$connect->close();
?>