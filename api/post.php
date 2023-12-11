<?php 

include "../function.php";
require "../db-connect.php";


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
        $stmt = $connect->prepare("INSERT INTO posts (title, description, phone, email, address, image) VALUES (?, ?, ?, ?, ?, ?)");
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
}

$connect->close();
?>