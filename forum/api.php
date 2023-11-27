<?php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'edonatemo');

//connecting to database and getting the connection object
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

//Checking if any error occured while connecting
if (mysqli_connect_errno()) {
echo "Failed to connect to MySQL: " . mysqli_connect_error();
die();
}


$stmt = $conn->prepare("SELECT * FROM posts;");

$stmt->execute();

$stmt->bind_result($postID, $accID, $title, $content);

$product = array();

while($stmt->fetch()){
    $temp = array();
    $temp['postID'] = $postID;
    $temp['accID'] = $accID;
    $temp['title'] = $title;
    $temp['content'] = $content;


    array_push($product, $temp);


}

echo json_encode($product);
?>