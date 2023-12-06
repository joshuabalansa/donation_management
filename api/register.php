<?php

include "../function.php";
require "../db-connect.php";

if (isset($_POST['email'])) {

    $name = $connect->real_escape_string($_POST['name']);
    $email = $connect->real_escape_string($_POST['email']);
    $password = $connect->real_escape_string($_POST['password']);
    $password_confirm = $connect->real_escape_string($_POST['password_confirm']);
    $contact = $connect->real_escape_string($_POST['contact']);
    $address = $connect->real_escape_string($_POST['address']);

    $error = [];

    if (empty($name)) {
        $error['name'] = 'Name is required!';
    }

    if (empty($email)) {
        $error['email'] = 'Email is required!';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error['email'] = 'Invalid Email format!';
    } elseif (check_user_email($connect, $email)) {
        $error['email'] = 'Email already exists!';
    }

    if (empty($password)) {
        $error['password'] = 'Password is required!';
    } elseif ($password != $password_confirm) {
        $error['password'] = 'Password does not match!';
    }
    if (empty($contact)) {
        $error['contact'] = 'Contact is required!';
    }

    if (empty($address)) {
        $error['address'] = 'Address is required!';
    }

    if (count($error) <= 0) {

        $sql = "INSERT INTO users (name, email, password, contact, address, token, created_at) VALUES ('$name', '$email', '".md5($password)."', '$contact', '$address', '', NOW())";

        if ($connect->query($sql) === TRUE) {
            returnJson(['message' => 'Record created successfully']);
        } else {
            returnJson(['errors' => "Error: " . $sql . "<br>" . $connect->error]);
        }
    } else {
        returnJson(['errors' => $error]);
    }
}

$connect->close();
returnJson([]);
?>