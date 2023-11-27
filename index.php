<?php


session_start();
include "function.php";
require "db-connect.php";

$email = '';
$password = '';

if (isset($_POST['loginBtn'])) {

    $email = $connect->real_escape_string($_POST['email']);
    $password = $connect->real_escape_string($_POST['password']);

    $error = [];

    if (empty($email)) {
        $error['email'] = 'Email is required!';
    }

    if (empty($password)) {
        $error['password'] = 'Password is required!';
    }

    $auth = authUser($connect, $email, $password);

    if (!is_null($auth)) {
        $_SESSION['user'] = $auth;
        header('Location: main.php');
    } else {
        $error['email'] = 'Invalid Email and Password!';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/login.css">
    <title>Login Page</title>
</head>
<body>
<header>
        <img src="images/edlogo.png" alt="Logo">
        <h1>E - Donate Mo</h1>
    </header>
    <h2>Admin Login</h2>
    <form action="index.php" method="post">
        <label for="email">Email: <?php echo (isset($error['email']))? $error['email'] : '';?></label>
        <input type="text" id="email" name="email" ><br>

        <label for="password">Password: <?php echo (isset($error['password']))? $error['password'] : '';?></label>
        <input type="password" id="password" name="password" ><br>

        <input type="submit" value="Login" name="loginBtn">
    </form>
</body>
</html>
