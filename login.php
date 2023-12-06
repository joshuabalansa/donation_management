<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $expectedUsername = "admin";
    $expectedPassword = "admin123";
 
    $username = $_POST["username"];
    $password = $_POST["password"];

    if ($username == $expectedUsername && $password == $expectedPassword) {

        header("Location: main.php");
        exit();
    } else {

        echo "Invalid username or password. Please try again.";
    }
}
?>
