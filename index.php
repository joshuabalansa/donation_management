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
        $error['email'] = 'Invalid email or password!';
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
    <style type="text/css">
        .sign-up {
            padding: 10px;
            background-color: #0e9d24;
            display: block;
            text-decoration: none;
            font-size: 12px;
        }
        .sign-up:link,
        .sign-up:visited,
        .sign-up:active {
            text-decoration: none;
            color: #fff;
        }
    </style>
</head>
<body>
<header>
        <img src="images/edlogo.png" alt="Logo">
        <h1>E - Donate Mo</h1>
    </header>
    <h2>Admin Login</h2>
    <form action="index.php" method="post">
        <label for="email">Email:</label>
        <input type="text" id="email" name="email" ><br>

        <label for="password">Password: <span class="error-msg"><?php echo (isset($error['password']))? $error['password'] : '';?></span></label>
        <input type="password" id="password" name="password" ><br>

        <input type="submit" value="Login" name="loginBtn">
        <a href="signup.php" class="sign-up">Sign Up</a>
        <?php echo (isset($error['email'])) ? $error['email'] : '';?>
    </form>
</body>
</html>
