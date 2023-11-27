<?php

$servername = 'localhost';
$username = 'root';
$password = '';
$databasename = 'edonatemo';

$connect = new mysqli($servername, $username, $password, $databasename);

if ($connect->connect_error) {
	die("Connection failed: " . $connect->connect_error);
} 

?>