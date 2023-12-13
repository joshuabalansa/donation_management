<?php

include "../function.php";
require "../db-connect.php";

if (!isset($_GET['user_id'])) {
	returnJson([]);
}

$user_id = $connect->real_escape_string($_GET['user_id']);

$method = $_SERVER['REQUEST_METHOD'];

if($method === 'GET') {

    $result = $connect->query("SELECT * FROM donations");

    $data = array();
    while($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    returnJson($data); 
} else if($method === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (empty($data['name'] || empty($data['description']) || empty($data['phone'] || empty($data['email']) || empty($data['donationType']) || empty($data['donation']) || empty($data['image'])))) {
        returnJson(array(
            "error" => "Missing required fields"
        ));
    } else {
        $sql = "INSERT INTO donations (name, description, phone, email, donationType, donation, image) VALUES (?, ?, ?,?, ?, ?, ? )";
        $sql = $connect->prepare($sql);

        $sql->bind_param('sssssss', $data['name'], $data['description'], $data['phone'], $data['email'], $data['donationType'], $data['donation'], $data['image']);

        if($sql->execute()) {
            returnJson(array(
                "Message" => "Data inserted successfully"
            )); 
        } else {
            returnJson(array(
                "error" => "Failed to insert data"
            ));
        }
    }
} elseif($method == "PUT") {

    $data = json_decode(file_get_contents('php://input'), true);

    if (empty($data['name'] || empty($data['description']) || empty($data['phone'] || empty($data['email']) || empty($data['donationType']) || empty($data['donation']) || empty($data['image'])))) {
        returnJson(array(
            "error" => "Missing required fields"
        ));
    } else {
        $sql = "UPDATE donations SET name = ?, description = ?, phone = ?, email = ?, donationType = ?, donation = ?, image = ? WHERE id = ? ";

        $sql = $connect->prepare($sql);

        $sql->bind_param('sssssssi', $data['name'], $data['description'], $data['phone'], $data['email'], $data['donationType'], $data['donation'], $data['image'], $data['id']);

        if($sql->execute()) {
            returnJson(array(
                "Message" => "Data updated successfully"
            )); 
        } else {
            returnJson(array(
                "error" => "Failed to update the data"
            ));
        }
    }
}elseif ($method === 'DELETE') {
   
    $data = json_decode(file_get_contents("php://input"), true);
    $stmt = $connect->prepare("DELETE FROM donations WHERE id = ?");
    $stmt->bind_param("i", $data['id']);
    $stmt->execute();

    echo json_encode(array("message" => "Data deleted successfully"));
}

$connect->close();



?>