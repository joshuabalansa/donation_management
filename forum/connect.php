<?php
//
// filename: connect.php
$hostname = "localhost";
$username = "root";
$password = "";
$database = "edonatemo";

$conn = mysqli_connect($hostname, $username, $password, $database);
if (!$conn) {
    echo "Unable to connect to database<strong>" . $database . "</strong><br />";
    echo mysqli_connect_error();
}
